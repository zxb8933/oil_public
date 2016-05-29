$(document).ready(function(){
				
				function ajaxForm(name){
					$("#set"+name).click(function(){
						$("#form").load("form/set"+name+".html");
					});
					$("#modify"+name).click(function(){
						$("#form").load("form/modify"+name+".html");
					});
				}
				ajaxForm("Company");
				ajaxForm("Line");
				ajaxForm("Tester");
				ajaxForm("Site");
				ajaxForm("Power");
				ajaxForm("Testpoint");
				ajaxForm("Online-equip");
				ajaxForm("Manual-equip");
				ajaxForm("Cutout");
			})