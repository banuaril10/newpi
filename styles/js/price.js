document.getElementById("btn-cetak-tinta").addEventListener("click", function() { //cetak besar ini yg dipake
				var array = [];
				var checkboxes = document.querySelectorAll('input[type=checkbox]:checked');
				var brand = document.getElementById('brand').value;
				
				
				if(brand == 'IDOLMART'){
					
					brand = brand+" UNIK ";
					
				}
				
				
				for (var i = 0; i < checkboxes.length; i++) {
					array.push(checkboxes[i].value)
				}
				let text = "<table><tr>";
				// let text = "<div style='position: relative; width: 920px; height: 135px; padding-top: 25px; border: 1px solid #000;'>";
				
				var x = 1;
				for (let i = 0; i < array.length; i++) {
						var res = array[i].split("|");
						
						if(res[5] === 'undefined' || res[5] === 'null' || res[5] === ''){
							
							var sc = '';
						}else{
							var sc = ' / '+res[5];
						}
						
						if(x==5){
							var x = 1;
						}

						var lengthh = res[1].length;
						var panjangharga = parseInt(res[2]);
	
						
						var sizeprice = "47px";
						if(lengthh > 33){
							
							 sizeprice = "47px";
						}
						
						if(panjangharga > 999999){
							sizeprice = "43px";
							
						}
						
						if(res[4] != ""){
							var rack = res[8]+"/"+res[0]+"/"+res[4]+"/"+res[7];
							
							
						}else{
							
							var rack = res[8]+"/"+res[0]+"/NO_RACK/"+res[7];
						}
						
						// <br style='line-height: 70%;'>
			

						var newStr = rack.replace('-', '_');
						var tgl_cetak = res[8];
						
							text += "<td style='border: 0.5px solid #000'><div style='margin:5px 5px 0 5px; color: black; width: 177px; height: 121px; font-family: Calibri; '><div style='height:30px; text-align: left; font-size: 10px'><b>"+res[1].toUpperCase()+"</b></div><label style='margin: -10px 0 0 0; float: right; font-size: "+sizeprice+"'><label style='font-size: 10px'><b>Rp </b></label><b>"+formatRupiah(res[2], '')+"</b></label><label style='text-align: left; font-size: 8px; width: 100%'>"+newStr+"</label><center><hr style='border-top: solid 1px #000 !important; background-color:black; border:none; height:1px; margin:5px 0 5px 0;'><label style='text-align: center; font-size: 8px; margin-top: 10px'>"+brand+" MURAH DAN LENGKAP</label></center></div></td>";
							
						
						
							if((i+1)%4==0 && i!==0){
							
								text += "</tr><tr>";
							}
							x++;

					}
			
				text += "</table>";
					

				  var mywindow = window.open('', 'my div', 'height=600,width=800');
							/*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
							mywindow.document.write('<style>@media print{@page {size: potrait; width: 216mm;height: 280mm;margin-top: 15;margin-right: 2;margin-left: 2; padding: 0;} margin: 0; padding: 0;} table { page-break-inside:auto }tr{ page-break-inside:avoid; page-break-after:auto }</style>');
							mywindow.document.write(text);

					
							mywindow.print();
							// mywindow.close();
					
							return true;
			});