/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){

    $.validator.addMethod("mobchecktest",
        function(value, element) {
            return /^[9 8 7]\d{9}$/.test(value);
    });
        
    $.validator.addMethod("namecharcheck",
                     function(value, element) {
                        return /^[a-zA-Z0-9\s]*$/.test(value);
    });
    
//    $.validator.addMethod("expirymonth",
//        function (value, element) {
//            var today = new Date();
//            var expMonth = value;
//            return (expMonth >= 1 
//                    && expMonth <= 12
//                     ? true : false)
//        }
//    );
//    
//    $.validator.addMethod("expiryyear",
//        function (value, element) {
//            var today = new Date();
//            var thisYear = today.getFullYear();
//            var expYear = value;
//         
//
//            return ((expYear >= thisYear && expYear < thisYear + 10)? false : true);
//            }
//    );  

    function get_browser_info(){
        var ua=navigator.userAgent,tem,M=ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || []; 
        if(/trident/i.test(M[1])){
            tem=/\brv[ :]+(\d+)/g.exec(ua) || []; 
            return {name:'IE ',version:(tem[1]||'')};
            }   
        if(M[1]==='Chrome'){
            tem=ua.match(/\bOPR\/(\d+)/)
            if(tem!=null)   {return {name:'Opera', version:tem[1]};}
            }   
        M=M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
        if((tem=ua.match(/version\/(\d+)/i))!=null) {M.splice(1,1,tem[1]);}
        return {
          name: M[0],
          version: M[1]
        };
    }

});

