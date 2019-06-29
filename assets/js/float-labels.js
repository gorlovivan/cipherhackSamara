function setFltLblsUp(a){if(a.val()!=""){a.closest(".flt-lbl-box").addClass("flt-lbl-up")
}}function setFltLbls(){$(".flt-lbl-up").removeClass("flt-lbl-up");
$(document.body).on("focus",".flt_lbl_inp",function(){$(this).closest(".flt-lbl-box").addClass("flt-lbl-up")
});
$(document.body).on("blur",".flt_lbl_inp",function(){var a=$(this);
if(!a.val().length){a.closest(".flt-lbl-box").removeClass("flt-lbl-up")
}});
$(".flt_lbl_inp").each(function(){setFltLblsUp($(this))
})
}$(document).ready(function(){setFltLbls()
});