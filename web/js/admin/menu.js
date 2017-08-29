'use strict';

(()=>{

    function menu(top){

        let y = window.scrollY;
        let objDiv = document.getElementById("admin");
        let page_height= objDiv.scrollHeight;

        // console.log(y);

        if(y > 160){
//                    $( "#menu_admin" ).removeClass( 'navbar');
//                    $( "#menu_admi narticle" ).addClass( 'navbar-fixed');
            $("#menu_admin article").css("position", 'fixed');
            $("#menu_admin article").css("top", top+"px");


            let footer_height = $('footer').height();
            let limit_height = page_height - footer_height;

            console.log("taille limite = "+limit_height+", nous sommes actuellement à "+y+" pixel(s) du top");

            if(y > limit_height){

                console.log("on est au dessus");
                $("#menu_admin article").css("top", "unset");
                $("#menu_admin article").css("bottom", (90+footer_height)+"px");
            }
            else{
                $("#menu_admin article").css("bottom", "unset");
            }
        }
        else{
//                    $( "#menu_admin" ).removeClass( 'navbar-fixed');
//                    $( "#menu_admin" ).addClass( 'navbar');
            $("#menu_admin article").css("position", 'relative');
            $("#menu_admin article").css("top", "unset");
        }


    }

    $(document).ready(()=>{
        $(window).scroll(()=> {
            menu(100);
        });
        menu(100);

    });
})();




