<?php

class Petrovich {

    private $rules; //Правила

    const CASE_NOMENATIVE = -1; //именительный
    const CASE_GENITIVE = 0; //родительный
    const CASE_DATIVE = 1; //дательный
    const CASE_ACCUSATIVE = 2; //винительный
    const CASE_INSTRUMENTAL = 3; //творительный
    const CASE_PREPOSITIONAL = 4; //предложный

    const GENDER_ANDROGYNOUS = 0; // Пол не определен
    const GENDER_MALE = 1; // Мужской
    const GENDER_FEMALE = 2; // Женский
    
	private $gender = Petrovich::GENDER_ANDROGYNOUS; //Пол male/мужской female/женский

    /**
     * Конструтор класса Петрович
     * загружаем правила из файла rules.json
     */
    function __construct($gender = Petrovich::GENDER_ANDROGYNOUS, $rules_dir = __DIR__) {
        
        $rules_path = $rules_dir.'/rules/rules.json';
        $rules_resourse = fopen($rules_path, 'r');

        if($rules_resourse == false)
            throw new Exception('Rules file not found.');

        $rules_array = fread($rules_resourse,filesize($rules_path));
        fclose($rules_resourse);

        $this->rules = get_object_vars(json_decode($rules_array));

        if (isset($gender) && $gender != Petrovich::GENDER_ANDROGYNOUS)
            $this->gender = $gender;
    }

    /**
    * Определяет пол по отчеству
    * @param $middlename
    * @return integer
    * @throws Exception
    */
    public function detectGender($middlename)
    {
        if(empty($middlename))
            throw new Exception('Middlename cannot be empty.');

        switch ( mb_substr( mb_strtolower($middlename) , -2))
        {
            case 'ич': return Petrovich::GENDER_MALE; break;
            case 'на': return Petrovich::GENDER_FEMALE; break;
            default: return Petrovich::GENDER_ANDROGYNOUS; break;
        }
    }

    /**
     * Задаём имя и слоняем его
     *
     * @param $firstname
     * @param $case
     * @return bool|string
     * @throws Exception
     */
    public function firstname($firstname, $case = Petrovich::CASE_NOMENATIVE) {
        if(empty($firstname))
            throw new Exception('Firstname cannot be empty.');

        if ($case === Petrovich::CASE_NOMENATIVE) {
            return $firstname;
        }

        return $this->inflect($firstname,$case,__FUNCTION__);
    }

    /**
     * Задём отчество и склоняем его
     *
     * @param $middlename
     * @param $case
     * @return bool|string
     * @throws Exception
     */
    public function middlename($middlename, $case = Petrovich::CASE_NOMENATIVE) {
        if(empty($middlename))
            throw new Exception('Middlename cannot be empty.');

        if ($case === Petrovich::CASE_NOMENATIVE) {
            return $middlename;
        }

        return $this->inflect($middlename,$case,__FUNCTION__);
    }

    /**
     * Задаём фамилию и слоняем её
     *
     * @param $lastname
     * @param $case
     * @return bool|string
     * @throws Exception
     */
    public function lastname($lastname, $case = Petrovich::CASE_NOMENATIVE) {
        if(empty($lastname))
            throw new Exception('Lastname cannot be empty.');

        if ($case === Petrovich::CASE_NOMENATIVE) {
            return $lastname;
        }

        return $this->inflect($lastname,$case,__FUNCTION__);
    }

    /**
     * Функция проверяет заданное имя,фамилию или отчество на исключение
     * и склоняет
     *
     * @param $name
     * @param $case
     * @param $type
     * @return bool|string
     */
    private function inflect($name,$case,$type) {
        $names_arr = explode('-', mb_convert_case($name, MB_CASE_TITLE, "UTF-8"));
        $result = array();

        foreach($names_arr as $arr_name) {
            if(($exception = $this->checkException($arr_name,$case,$type)) !== false) {
                $result[] = $exception;
            }
            else {
                $result[] = $this->findInRules($arr_name,$case,$type);
            }
        }
        return implode('-',$result);
    }

    /**
     * Поиск в массиве правил
     *
     * @param $name
     * @param $case
     * @param $type
     * @return string
     */
    private function findInRules($name,$case,$type) {
        foreach($this->rules[$type]->suffixes as $rule) {
            if ( ! $this->checkGender($rule->gender) )
                continue;
            foreach($rule->test as $last_char) {
                $last_name_char = mb_substr($name,mb_strlen($name)-mb_strlen($last_char),mb_strlen($last_char));
                if($last_char == $last_name_char) {
                    if($rule->mods[$case] == '.')
                        return $name;
                    return $this->applyRule($rule->mods,$name,$case);
                }
            }
        }
        return $name;
    }

    /**
     * Проверка на совпадение в исключениях
     *
     * @param $name
     * @param $case
     * @param $type
     * @return bool|string
     */
    private function checkException($name,$case,$type) {
        if(!isset($this->rules[$type]->exceptions))
            return false;

        $lower_name = mb_strtolower($name);

        foreach($this->rules[$type]->exceptions as $rule) {
            if ( ! $this->checkGender($rule->gender) )
                continue;
            if(array_search($lower_name,$rule->test) !== false) {
                if($rule->mods[$case] == '.')
                    return $name;
                return $this->applyRule($rule->mods,$name,$case);
            }
        }
        return false;
    }

    /**
     * Склоняем заданное слово
     *
     * @param $mods
     * @param $name
     * @param $case
     * @return string
     */
    private function applyRule($mods,$name,$case) {
        $result = mb_substr($name,0,mb_strlen($name) - mb_substr_count($mods[$case],'-'));
        $result .= str_replace('-','',$mods[$case]);
        return $result;
    }

    /**
    * Преобразует строковое обозначение пола в числовое
    * @param string
    * @return integer
    */
    private function getGender($gender) {
        switch($gender) {
            case 'male': return Petrovich::GENDER_MALE; break;
            case 'female': return Petrovich::GENDER_FEMALE; break;
            case 'androgynous': return Petrovich::GENDER_ANDROGYNOUS; break;
        }
    }

    /**
    * Проверяет переданный пол на соответствие установленному
    * @param string
    * @return bool
    */
    private function checkGender($gender) {
        return $this->gender === $this->getGender($gender) || $this->getGender($gender) === Petrovich::GENDER_ANDROGYNOUS;
    }
}
