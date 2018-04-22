$(function(){
	// Phone Mask
	$(".phone").mask("(9999) 999-9999");
	// Date Mask
	$(".date").datepicker({dateFormat: 'dd-mm-yy'});

	$(".monto").maskMoney({thousands:'.', decimal:','});

	// Date Mask FROM / TO
	var dateFormat = "yy-mm-dd",
	from = $(".from" ).datepicker({dateFormat: 'dd-mm-yy'})
	.on( "change", function() {
		to.datepicker( "option", "minDate", getDate( this ) );
	}),
	to = $(".to").datepicker({dateFormat: 'dd-mm-yy'})
	.on( "change", function() {
		from.datepicker( "option", "maxDate", getDate( this ) );
	});

	$("body").tooltip({
    	selector: '[data-toggle="tooltip"]'
	});

	function getDate( element ) {
		var date;
		try {
			date = $.datepicker.parseDate( dateFormat, element.value );
		} catch( error ) {
			date = null;
		}

		return date;
	}

	// Search engine
	$('body').on('keyup', 'input[id=searcher_01]', function (event){
		var searching_text = $(this).val();
		var string;

		$("table tbody tr").each(function(){
			str = $(this).text()
			if( str.toLowerCase().search(searching_text.toLowerCase()) < 0){
			   $(this).fadeOut();
			}else{
				$(this).fadeIn();
			}
		});
	});

	// BOTON CAMBIAR ESTADO GENERAL
	$('body').on('click', '.cambiar_estado', function (event){
		var boton = $(this)
		var id = $(this).attr("id")
		var de = $(this).attr("de")
		var estado = $(this).attr("estado")

		alertify.confirm("Confirmar", "¿Desea eliminarlo?",
			function(){
				$.ajax({
					type: "POST",
					url: "peticiones.php",
					data: {id, de, accion:'cambiar_estado', estado},
					dataType: "json",
					cache: false,
					beforeSend: function(obj){
						boton.attr("disabled", true)
					},
					success: function(datos){
						boton.attr("disabled", false)
						if(datos.exitoso){
							alertify.alert('Mensaje', '¡Eliminado exitosamente!', function(){ 
								if(datos.refrescar){
									location.reload()
								}
							})
						}else{
							alertify.alert('Mensaje', datos.error)
						}
					}
				})
			},
			function(){
				// on cancel
			}
		)
	})

	$('body').on('click', '.delete_from', function (event){
		var boton = $(this)
		var id = $(this).attr("id")
		var de = $(this).attr("de")

		$.ajax({
			type: "POST",
			url: "peticiones.php",
			data: {id, de, accion:'delete_from'},
			dataType: "json",
			cache: false,
			beforeSend: function(obj){
				boton.attr("disabled", true)
			},
			success: function(datos){
				boton.attr("disabled", false)
				if(datos.exitoso){
					alertify.alert('Mensaje', '¡Eliminado exitosamente!', function(){ 
						if(datos.refrescar){
							location.reload()
						}
					})
				}else{
					alertify.alert('Mensaje', datos.error)
				}
			}
		})
	})

	$('body').on('change', '.cambiar_estado_select', function (event){
		var _select = $(this);
		var id = $(this).attr("id")
		var de = $(this).attr("de")
		var estado = $(this).val()
		
		$.ajax({
			type: "POST",
			url: "peticiones.php",
			data: {accion:'cambiar_estado_servicio', id, estado, de},
			beforeSend: function(obj){
				_select.attr("disabled", true)
			},
			success: function(datos){
				_select.attr("disabled", false)
				if(datos==''){
					_select.css("border", "1px solid green")
				}else{
					_select.css("border", "1px solid red")
				}
			}
		})
		event.preventDefault();
	})

	$('body').on('click', '.eliminar_elemento', function (event){
		var boton = $(this)
		var id = $(this).attr("id")
		var de = $(this).attr("de")

		alertify.confirm("Confirmar", "¿Desea eliminarlo?",
			function(){
				$.ajax({
					type: "POST",
					url: "peticiones.php",
					data: {id, de, accion:'eliminar_elemento'},
					dataType: "json",
					cache: false,
					beforeSend: function(obj){
						boton.attr("disabled", true)
					},
					success: function(datos){
						boton.attr("disabled", false)
						if(datos.exitoso){
							alertify.alert('Mensaje', '¡Eliminado exitosamente!', function(){ 
								if(datos.refrescar){
									location.reload()
								}
								//ejecuta una accion devuelta segn la peticion
								switch(datos.ejecutar){
									case 'cargar_serv_defecto':
										cargar_serv_defecto()
									break;
								}
							})
						}else{
							alertify.alert('Mensaje', datos.error)
						}
					}
				})
			},
			function(){
				// on cancel
			}
		)
	})

	$('body').on('click', '.eliminar_de_tabla', function (event){
		var boton = $(this)
		var id = $(this).attr("id")
		var de = $(this).attr("de")
		var id_nota_extintor = $(this).attr("id_nota_extintor")

		alertify.confirm("Confirmar", "¿Desea eliminarlo?",
			function(){
				$.ajax({
					type: "POST",
					url: "peticiones.php",
					data: {id, de, accion:'eliminar_de_tabla'},
					dataType: "json",
					cache: false,
					beforeSend: function(obj){
						boton.attr("disabled", true)
					},
					success: function(datos){
						boton.attr("disabled", false)
						if(datos.exitoso){
							alertify.alert('Mensaje', '¡Eliminado exitosamente!', function(){ 
								// recargar ver servicios
								$.ajax({
									type: "POST",
									url: "peticiones.php",
									data: {id_nota_extintor, accion:'verServicios_de_extintores'},
									success: function(datos){
										$("#recargar_servicios").html(datos)
									}
								})
							})
						}else{
							alertify.alert('Mensaje', datos.error)
						}
					}
				})
			},
			function(){
				// on cancel
			}
		)
	})

	$('body').on('click', '.cancelar_nota', function (event){
		var boton = $(this)
		var id = boton.attr("id")

		alertify.prompt( 'Cancelar nota de servicio', 'Observación', ''
            ,function(evt, value){
                $.ajax({
					type: "POST",
					url: "peticiones.php",
					data: {id, accion:'cancelar_nota', observacion:value},
					beforeSend: function(obj){
						boton.attr("disabled", true)
					},
					success: function(datos){
						boton.attr("disabled", false)
						if(datos == ''){
							location.reload()
						}else{
							alertify.alert('Mensaje', datos)
						}
					}
				})
            }
            ,function(){ 
            	alertify.error('Cancel') 
        });
	})

	$('body').on('click', '.escoger_categoria', function (event){
		var id = $(this).attr("id")

		$.ajax({
			type: "POST",
			url: "peticiones.php",
			data: {id, accion:'cargar_extintores'},
			beforeSend: function(obj){
				
			},
			success: function(datos){
				$("#cargar_extintores").html(datos)
			}
		})
	})

	$('body').on('click', '.recargar_serv_defecto', function (event){
		var id = $(this).attr("id")
		$("#confServiciosExtintor").find("input[name=id_extintor]").val(id)
		$.ajax({
			type: "POST",
			url: "peticiones.php",
			data: {id, accion:'recargar_serv_defecto'},
			beforeSend: function(obj){
				
			},
			success: function(datos){
				$("#cargar_serv_defecto").html(datos)
			}
		})
	})

	$('body').on('submit', '#buscarCliente', function (event){
		var predocumento = $(this).find("select[name=predocumento]").val()
		var documento = $(this).find("input[name=documento]").val()
		var boton = $(this).find("button[type=submit]");
		var boton_txt = boton.text();

		$.ajax({
			type: "POST",
			url: "peticiones.php",
			data: {documento: predocumento+documento, accion:'obtener_cliente_by_documento'},
			dataType: "json",
			cache: false,
			beforeSend: function(obj){
				boton.text("Buscando...")
			},
			success: function(datos){
				boton.text(boton_txt)
				var clienteForm = $("#cliente_quick_form")
				if(datos.exitoso){
					clienteForm.find('input[name=id]').val(datos.id)
					clienteForm.find('select[name=predocumento]').val(datos.predocumento)
					clienteForm.find('input[name=documento]').val(datos.documento)
					clienteForm.find('input[name=cliente]').val(datos.cliente)
					clienteForm.find('input[name=email]').val(datos.email)
					clienteForm.find('input[name=telefono1]').val(datos.telefono1)
					clienteForm.find('input[name=telefono2]').val(datos.telefono2)
					clienteForm.find('textarea[name=direccion]').val(datos.direccion).attr("disabled", true)
					clienteForm.find('button[type=submit]').attr("disabled", true)
					clienteForm.find('input').attr("disabled", true)
					$("#buscarCliente").find("input[name=documento]").val('')
				}else{
					clienteForm[0].reset();
					clienteForm.find('input[name=id]').val(0)
					clienteForm.find('button[type=submit]').attr("disabled", false)
					clienteForm.find('input').attr("disabled", false);
					clienteForm.find('textarea[name=direccion]').attr("disabled", false);
					clienteForm.find('select[name=predocumento]').val(predocumento)
					clienteForm.find('input[name=documento]').val(documento).focus().select();
					$("#buscarCliente").find("input[name=documento]").val('')
				}
			}
		});
		event.preventDefault();
	})

	$('body').on('submit', '#cliente_quick_form', function (event){
		var parametros = $(this).serialize();
		var button = $(this).find("button[type=submit]")
		button.button_txt = button.text()
		
		$.ajax({
			type: "POST",
			url: "peticiones.php",
			data: parametros,
			dataType: "json",
			cache: false,
			beforeSend: function(obj){
				button.attr("disabled", true).text("Espere...")
			},
			success: function(datos){
				button.attr("disabled", false).text(button.button_txt)
				if(datos.exitoso){
					alertify.alert('Mensaje', '¡Registro exitoso!', function(){ 
						$("#buscarCliente").find("select[name=predocumento]").val(datos.predocumento)
						$("#buscarCliente").find("input[name=documento]").val(datos.documento)
						$("#buscarCliente").trigger("submit")
					})
				}else{
					alertify.alert('Mensaje', datos.error)
				}
			}
		})
		event.preventDefault();
	})

	$('body').on('submit', '#guardarNotaForm', function (event){
		event.preventDefault();
		var button = $(this).find("button[type=submit]")
		button.button_txt = button.text()
		var nota = {};
		var id_cliente = $("#cliente_quick_form").find("input[name=id]").val()
		var i = 0;

		$("table#table_ext tbody tr").each(function(){
			nota[i] = {}
			nota[i]['id_ext_categoria'] = $(this).find("select[name=id_ext_categoria]").val()
			nota[i]['id_extintor'] = $(this).find("select[name=id_extintor]").val()
			nota[i]['id_ser_categoria'] = $(this).find("select[name=id_ser_categoria]").val()
			nota[i]['cantidad'] = $(this).find("select[name=cantidad]").val()
			i++
		})
	
		alertify.confirm("Confirmar", "¿Confirma la emisión de esta nota de servicio?",
			function(){
				$.ajax({
					type: "POST",
					url: "peticiones.php",
					data: {id_cliente, nota, accion:'guardar_nota_servicio'},
					dataType: "json",
					cache: false,
					beforeSend: function(obj){
						button.attr("disabled", true).text("Procesando...")
					},
					success: function(datos){
						button.attr("disabled", false).text(button.button_txt)
						if(datos.exitoso){
							location.href = 'confirmacionOrden.php';
						}else{
							alertify.alert('Mensaje', datos.error)
						}
					}
				})
			},
			function(){
				// on cancel
			}
		)
	})


	$('body').on('click', '.delete_this_tr', function(event){
		var table_tr = $("table#table_ext tbody tr")
		if(table_tr.length > 1){
			$(this).parents("tr").remove()
		}
	})

	$("#restaurarClave").submit(function( event ) {
		var form = $(this);
		var parametros = $(this).serialize()
		$.ajax({
			type: "POST",
			url: "peticiones.php",
			data: parametros,
			beforeSend: function(objeto){			
				form.find("button[type=submit]").html("Enviando <img style='height:20px' src='images/white-loader.gif'/>").attr("disabled", true)
			},
			success: function(datos){
				form.find("button[type=submit]").html("Enviar").attr("disabled", false)
				alertify.alert('Mensaje', datos)
			}
		});
		event.preventDefault();
	});

	$("body").on("click", ".remover_ser_extintor", function(){
		obj = $(this)
		var position = obj.attr("position")
		var index = obj.attr("index")

		$.ajax({
			type: "POST",
			url: "peticiones.php",
			data: {position, index, accion:'remover_ser_extintor'},
			beforeSend: function(objeto){			
				obj.attr("disabled", true)
			},
			success: function(datos){
				obj.attr("disabled", false)
				if(datos==''){
					location.reload()
				}else{
					alertify.alert('Mensaje', datos)
				}
			}
		});
	})

	$("body").on("click", "#confirmar_orden_boton", function(){
		boton = $(this)
		boton.texto = boton.text()
		$.ajax({
			type: "POST",
			url: "peticiones.php",
			data: {accion:'procesar_orden'},
			beforeSend: function(objeto){			
				boton.attr("disabled", true).html("Guardando... <img src='images/white-loader.gif'/>");
			},
			success: function(datos){
				boton.attr("disabled", false).html(boton.texto);
				if(datos==''){
					alertify.alert('Mensaje', "¡Orden agregada satisfactoriamente!", function(){
						location.href = "buscarNotas.php"
					})
				}else{
					alertify.alert('Mensaje', datos)
				}
			}
		});
	})

	$('body').on('submit', '#buscar_notas_01', function (event){
		var parametros = $(this).serialize();
		var button = $(this).find("button[type=submit]");

		$("#ver_extintores_notas").html('<tr><td colspan="6"><em>Seleccionar nota</em></td></tr>');
		
		$.ajax({
			type: "POST",
			url: "peticiones.php",
			data: parametros,
			beforeSend: function(obj){
				button.attr("disabled", true)
			},
			success: function(datos){
				button.attr("disabled", false)
				$("#recargar_notas").html(datos)
			}
		})
		event.preventDefault();
	})

	$('body').on('submit', '#buscar_notas_02', function (event){
		var parametros = $(this).serialize();
		var button = $(this).find("button[type=submit]")
		
		$.ajax({
			type: "POST",
			url: "peticiones.php",
			data: parametros,
			beforeSend: function(obj){
				button.attr("disabled", true)
			},
			success: function(datos){
				button.attr("disabled", false)
				$("#recargar_notas").html(datos)
			}
		})
		event.preventDefault();
	})

	$('body').on('submit', '#buscar_extintor_fecha', function (event){
		var parametros = $(this).serialize();
		var button = $(this).find("button[type=submit]")
		
		$.ajax({
			type: "POST",
			url: "peticiones.php",
			data: parametros,
			beforeSend: function(obj){
				button.attr("disabled", true)
			},
			success: function(datos){
				button.attr("disabled", false)
				$("#recargar_tabla").html(datos)
			}
		})
		event.preventDefault();
	})

	$('body').on('submit', '#buscar_quimico_categoria', function (event){
		var parametros = $(this).serialize();
		var button = $(this).find("button[type=submit]")
		
		$.ajax({
			type: "POST",
			url: "peticiones.php",
			data: parametros,
			beforeSend: function(obj){
				button.attr("disabled", true)
			},
			success: function(datos){
				button.attr("disabled", false)
				$("#recargar_cantidad").html(datos)
			}
		})
		event.preventDefault();
	})

	$('body').on('submit', '#buscar_notas_03', function (event){
		var parametros = $(this).serialize();
		var button = $(this).find("button[type=submit]")
		
		$.ajax({
			type: "POST",
			url: "peticiones.php",
			data: parametros,
			beforeSend: function(obj){
				button.attr("disabled", true)
			},
			success: function(datos){
				button.attr("disabled", false)
				$("#recargar_notas").html(datos)
			}
		})
		event.preventDefault();
	})

	$('body').on('change', '.ubi_01', function (event){
		var _select = $(this);
		var id_ubicacion = $(this).val();
		var id_nota_extintor = $(this).attr("id");
		
		$.ajax({
			type: "POST",
			url: "peticiones.php",
			data: {accion:'cambiar_ubicacion_nota_extintor', id_ubicacion, id_nota_extintor},
			beforeSend: function(obj){
				_select.attr("disabled", true)
			},
			success: function(datos){
				_select.attr("disabled", false)
				if(datos==''){
					_select.css("border", "1px solid green")
				}else{
					_select.css("border", "1px solid red")
				}
			}
		})
		event.preventDefault();
	})
	
})

function recargar_extintores(id){
	$.ajax({
		type: "POST",
		url: "peticiones.php",
		data: {id, accion:'cargar_extintores'},
		beforeSend: function(obj){
			
		},
		success: function(datos){
			$("#confExtintores").modal("hide")
			$("#cargar_extintores").html(datos)
		}
	})
}

function cargar_servicio_por_tipo(tipo){
	$.ajax({
		type: "POST",
		url: "peticiones.php",
		data: {tipo, accion:'recargar_serv_defecto_tipo'},
		success: function(datos){
			$("#confServiciosExtintor").find("select[name=id_servicio]").html(datos)
		}
	})
	if(tipo=='servicio'){
		$("#confServiciosExtintor").find("input[name=cantidad]").attr("readonly", true).val(0)
	}else{
		$("#confServiciosExtintor").find("input[name=cantidad]").attr("readonly", false).val(0).focus()
	}
}

function cargar_servicio_por_tipoTaller(tipo){
	$.ajax({
		type: "POST",
		url: "peticiones.php",
		data: {tipo, accion:'recargar_serv_defecto_tipo'},
		success: function(datos){
			$("#confServiciosExtintorEnTaller").find("select[name=id_servicio]").html(datos)
		}
	})
	if(tipo=='servicio'){
		$("#confServiciosExtintorEnTaller").find("input[name=cantidad]").attr("readonly", true).val(0);
		$("#hideonmove").css("display", "none")
	}else{
		$("#confServiciosExtintorEnTaller").find("input[name=cantidad]").attr("readonly", false).val(0).focus();
		$("#hideonmove").css("display", "block")
	}
}

function cargar_serv_defecto(){
	var id = $("#confServiciosExtintor").find("input[name=id_extintor]").val()
	$.ajax({
		type: "POST",
		url: "peticiones.php",
		data: {id, accion:'recargar_serv_defecto'},
		beforeSend: function(obj){
			
		},
		success: function(datos){
			$("#cargar_serv_defecto").html(datos)
		}
	})
}

function cargar_extintores_by_categoria(obj){
	var id_ext_categoria = $(obj).val()
	$.ajax({
		type: "POST",
		url: "peticiones.php",
		data: {id_ext_categoria, accion:'recargar_ext_by_categoria_select'},
		success: function(datos){
			var tr_parent = $(obj).parents("tr").find("select[name=id_extintor]").html(datos)
		}
	})
}

function agregar_extintor_table(){
	$.ajax({
		type: "POST",
		url: "peticiones.php",
		data: {accion:'agregar_extintor_table'},
		success: function(datos){
			$("table#table_ext tbody").append(datos);
			$("table#table_ext tbody tr:last-child").find("select[name=id_ext_categoria]").trigger("change")
		}
	})
}

function respaldarr(){
	alertify.confirm("Confirmar", "¿Desea realizar el respaldo de la Base de Datos?",
		function(){
			$.ajax({
	            type: "POST",
	            url: "respaldo.php",
	            beforeSend: function(objeto){
	              $("#container_respaldo").html("<img src='images/white-loader.gif'/>");
	            },
	            success: function(datos){
	              $("#container_respaldo").html("");
	              alertify.alert("Mensaje", "El respaldo se ha ejecutado correctamente.", function(){
	              	location.reload();
	              })
	              
	            }
	        });
		},
		function(){
			// on cancel
		}
	)
}

function restaurarr(){
	alertify.confirm("Confirmar", "¿Desea realizar la restauración de la Base de Datos?",
		function(){
			$.ajax({
	            type: "POST",
	            url: "restaurarPickUp.php",
	            beforeSend: function(objeto){
	              $("#container_respaldo").html("<img src='images/white-loader.gif'/>");
	            },
	            success: function(datos){
	              $("#container_respaldo").html(datos);
	            }
	        });
		},
		function(){
			// on cancel
		}
	)
}

function ver_extintores_nota(id_nota){
	$.ajax({
	    type: "POST",
	    url: "peticiones.php",
	    data:{id_nota, accion:'ver_extintores_nota'},
	    beforeSend: function(objeto){
	     	$("#ver_extintores_notas").html("<img src='images/white-loader.gif'/>");
	    },
	    success: function(datos){
	     	$("#ver_extintores_notas").html(datos);
	    }
	});
}

function completar_servicio(id_nota){
	alertify.confirm("Confirmar", "¿Desea dar por terminado el servicio a esta orden?",
		function(){
			location.href='enviarNotificacionCliente.php?id_nota='+id_nota
	},
		function(){
			// on cancel
		}
	)
}

function chequear_productos_almacen(id_nota, obj){
	$.ajax({
	    type: "POST",
	    url: "peticiones.php",
	    data:{id_nota, accion:'chequear_productos_almacen'},
	    beforeSend: function(objeto){
	     	
	    },
	    success: function(datos){
	     	if(datos!=''){
	     		alertify.alert('Mensaje', datos)
	     	}else{
	     		alertify.alert('Mensaje', "Puede procesar todos los servicios para esta nota.")
	     	}
	    }
	});
}

function imprimir_nota(id){		
	$.ajax({
		type: "POST",
		url: "imprimir.php",
		data: {id, accion:'imprimir_nota'},
		success: function(datos){
			var win = window.open(' ', 'popimpr');
			win.document.write( datos );
			win.document.close();
		}
	})
}

function imprimir_reporte_01(guardaPdf = false){	
	var from = $("input[name=from").val()
	var to = $("input[name=to").val()
	var id_ubicacion = $("select[name=id_ubicacion").val()

	$.ajax({
		type: "POST",
		url: "imprimir.php",
		data: {from, to, id_ubicacion, guardaPdf, accion:'imprimir_reporte_01'},
		success: function(datos){
			if(guardaPdf===false){
				var win = window.open(' ', 'popimpr');
				win.document.write( datos );
				win.document.close();
			}else{
				guardarPDF(datos);
			}
		}
	})
}

function imprimir_reporte_02(guardaPdf = false){	
	var id_ext_categoria = $("select[name=id_ext_categoria").val()

	$.ajax({
		type: "POST",
		url: "imprimir.php",
		data: {id_ext_categoria, guardaPdf, accion:'imprimir_reporte_02'},
		success: function(datos){
			if(guardaPdf===false){
				var win = window.open(' ', 'popimpr');
				win.document.write( datos );
				win.document.close();
			}else{
				guardarPDF(datos);
			}
		}
	})
}

function imprimir_reporte_03(guardaPdf = false){	
	var id_nota = $("input[name=id_nota").val()
	var from = $("input[name=from").val()
	var to = $("input[name=to").val()
	var estado = $("select[name=estado").val()

	$.ajax({
		type: "POST",
		url: "imprimir.php",
		data: {id_nota, from, to, estado, guardaPdf, accion:'imprimir_reporte_03'},
		success: function(datos){
			if(guardaPdf===false){
				var win = window.open(' ', 'popimpr');
				win.document.write( datos );
				win.document.close();
			}else{
				guardarPDF(datos);
			}
		}
	})
}

function imprimir_reporte_04(guardaPdf = false){	
	var id_ext_categoria = $("select[name=id_ext_categoria").val()

	$.ajax({
		type: "POST",
		url: "imprimir.php",
		data: {id_ext_categoria, guardaPdf, accion:'imprimir_reporte_04'},
		success: function(datos){
			if(guardaPdf===false){
				var win = window.open(' ', 'popimpr');
				win.document.write( datos );
				win.document.close();
			}else{
				guardarPDF(datos);
			}
		}
	})
}

function imprimir_reporte_05(guardaPdf = false){	

	$.ajax({
		type: "POST",
		url: "imprimir.php",
		data: {guardaPdf, accion:'imprimir_reporte_05'},
		success: function(datos){
			if(guardaPdf===false){
				var win = window.open(' ', 'popimpr');
				win.document.write( datos );
				win.document.close();
			}else{
				guardarPDF(datos);
			}
		}
	})
}

function imprimir_reporte_06(id_ext, guardaPdf = false){	
	$.ajax({
		type: "POST",
		url: "imprimir.php",
		data: {id_ext, guardaPdf, accion:'imprimir_reporte_06'},
		success: function(datos){
			if(guardaPdf===false){
				var win = window.open(' ', 'popimpr');
				win.document.write( datos );
				win.document.close();
			}else{
				guardarPDF(datos);
			}
		}
	})
}

function print_grafica(type){	
	$.ajax({
		type: "POST",
		url: "print_grafica.php",
		data: {type},
		success: function(datos){
			var win = window.open(' ', 'popimpr');
			win.document.write( datos );
			win.document.close();
		}
	})
}

setInterval(function(){
	var datetime = new Date().toLocaleString();
	$("#time0").text(datetime);
}, 1000)

function guardarPDF(datos){
	var doc = new jsPDF('p', 'pt', 'a4', true);

    doc.fromHTML( datos, 15, 15, {
      'width': 500
    }, function (dispose) {
    	doc.save('report '+ getDate() +'.pdf');
    });
}

function getDate(){
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var yyyy = today.getFullYear();

	if(dd<10) {
	    dd = '0'+dd
	} 

	if(mm<10) {
	    mm = '0'+mm
	} 

	return mm + '/' + dd + '/' + yyyy;
}