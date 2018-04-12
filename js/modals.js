$('#confUsuarios').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var accion = button.data('accion')

	var modal = $(this)
	if(accion=='agregar'){
		title = 'Agregar nuevo usuario'
		modal.find('.modal-body input[name=accion]').val('registrar_usuario')
		modal.find('.modal-footer button[type=submit]').text('Guardar')
		$("#formModal")[0].reset()
	}else if(accion=='editar'){
		modal.find('.modal-body input[name=accion]').val('editar_usuario')
		title = 'Editar usuario'
		var id = button.data('id')
		$.ajax({
			type: "POST",
			url: "peticiones.php",
			data: {id, accion:'obtener_usuario_by_id'},
			dataType: "json",
			cache: false,
			success: function(datos){
				if(datos.exitoso){
					modal.find('.modal-body input[name=id]').val(datos.id)
					modal.find('.modal-body input[name=nombre]').val(datos.nombre)
					modal.find('.modal-body input[name=apellido]').val(datos.apellido)
					modal.find('.modal-body input[name=email]').val(datos.email)
					modal.find('.modal-body select[name=nivel]').val(datos.nivel)
					modal.find('.modal-body select[name=estado]').val(datos.estado)
					modal.find('.modal-body input[name=usuario]').val(datos.usuario)
					modal.find('.modal-body input[name=clave1]').val(datos.clave)
					modal.find('.modal-body input[name=clave2]').val(datos.clave)
				}
			}
		})

	}
	
	modal.find('.modal-title').text(title)
})

$('#confUsuarios').on('shown.bs.modal', function (event) {
	$(this).find("input[name=nombre]").focus().select();
})

$('#confClientes').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var accion = button.data('accion')

	var modal = $(this)
	if(accion=='agregar'){
		title = 'Agregar nuevo cliente'
		$("#formModal")[0].reset()
		modal.find('.modal-footer button[type=submit]').text('Guardar')
		modal.find('.modal-body input[name=accion]').val('registrar_cliente')
	}else if(accion=='editar'){
		modal.find('.modal-body input[name=accion]').val('editar_cliente')
		title = 'Editar cliente'
		var id = button.data('id')
		$.ajax({
			type: "POST",
			url: "peticiones.php",
			data: {id, accion:'obtener_cliente_by_id'},
			dataType: "json",
			cache: false,
			success: function(datos){
				if(datos.exitoso){
					modal.find('.modal-body input[name=id]').val(datos.id)
					modal.find('.modal-body select[name=predocumento]').val(datos.predocumento)
					modal.find('.modal-body input[name=documento]').val(datos.documento)
					modal.find('.modal-body input[name=cliente]').val(datos.cliente)
					modal.find('.modal-body input[name=email]').val(datos.email)
					modal.find('.modal-body select[name=nivel]').val(datos.nivel)
					modal.find('.modal-body input[name=telefono1]').val(datos.telefono1)
					modal.find('.modal-body input[name=telefono2]').val(datos.telefono2)
					modal.find('.modal-body textarea[name=direccion]').val(datos.direccion)
					modal.find('.modal-footer button[type=submit]').text('Guardar cambios')

				}
			}
		})




	}
	
	modal.find('.modal-title').text(title)
})

$('#confClientes').on('shown.bs.modal', function (event) {
	$(this).find("input[name=documento]").focus().select();
})

$('#confCategorias').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var accion = button.data('accion')

	var modal = $(this)
	if(accion=='agregar'){
		title = 'Agregar nueva categoría'
		$("#formModal")[0].reset()
		modal.find('.modal-footer button[type=submit]').text('Guardar')
		modal.find('.modal-body input[name=accion]').val('registrar_categoria')
		modal.find('.modal-body input[name=accion]').val('registrar_categoria')
	}else if(accion=='editar'){
		modal.find('.modal-body input[name=accion]').val('editar_categoria')
		title = 'Editar categoría'
		var id = button.data('id')

		$.ajax({
			type: "POST",
			url: "peticiones.php",
			data: {id, accion:'obtener_categoria_by_id'},
			dataType: "json",
			cache: false,
			success: function(datos){
				if(datos.exitoso){
					modal.find('.modal-body input[name=id]').val(datos.id)
					modal.find('.modal-body input[name=nombre]').val(datos.nombre)
					modal.find('.modal-footer button[type=submit]').text('Guardar cambios')
				}
			}
		})
	}
	
	modal.find('.modal-title').text(title)
})


$('#manageStock').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var accion = button.data('accion')
	var id = button.data('id')

	var modal = $(this)
	if(accion=='sumar'){
		title = 'Agregar al almacén'
		modal.find('.modal-body input[name=accion]').val('sumar_a_stuck')
	}else if(accion=='restar'){
		title = 'Restar almacén'
		modal.find('.modal-body input[name=accion]').val('restar_a_stuck')
	}
	modal.find('.modal-body input[name=id]').val(id)
	modal.find('.modal-body input[name=cantidad]').val(0)
	modal.find('.modal-title').text(title)
})

$('#manageStock').on('shown.bs.modal', function (event) {
	$(this).find("input[name=cantidad]").focus().select();
})

$('#confCategorias').on('shown.bs.modal', function (event) {
	$(this).find("input[name=nombre]").focus().select();
})

$('#confExtintores').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var accion = button.data('accion')

	var modal = $(this)
	if(accion=='agregar'){
		title = 'Agregar nuevo extintor'
		$("#formModal")[0].reset()
		modal.find('.modal-footer button[type=submit]').text('Guardar')
		modal.find('.modal-body input[name=accion]').val('registrar_extintor')
		modal.find('.modal-body input[name=capacidad]').val('')
		modal.find('.modal-body select[name=categoria]').attr("disabled", false)
	}else if(accion=='editar'){
		modal.find('.modal-body select[name=categoria]').attr("disabled", true)
		modal.find('.modal-body input[name=accion]').val('editar_extintor')
		title = 'Editar extintor' 
		var id = button.data('id')

		$.ajax({
			type: "POST",
			url: "peticiones.php",
			data: {id, accion:'obtener_extintor_by_id'},
			dataType: "json",
			cache: false,
			success: function(datos){
				if(datos.exitoso){
					modal.find('.modal-body input[name=id]').val(datos.id)
					modal.find('.modal-body select[name=categoria]').val(datos.id_ext_categoria)
					modal.find('.modal-body input[name=capacidad]').val(datos.capacidad)
					modal.find('.modal-footer button[type=submit]').text('Guardar cambios')
				}
			}
		})
	}
	
	modal.find('.modal-title').text(title)
})

$('#confExtintores').on('shown.bs.modal', function (event) {
	$(this).find("input[name=capacidad]").focus().select();
})

$('#confDepartamentos').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var accion = button.data('accion')

	var modal = $(this)
	if(accion=='agregar'){
		title = 'Agregar nueva ubicación'
		$("#formModal")[0].reset()
		modal.find('.modal-footer button[type=submit]').text('Guardar')
		modal.find('.modal-body input[name=accion]').val('registrar_departamento')
	}else if(accion=='editar'){
		modal.find('.modal-body input[name=accion]').val('editar_departamento')
		modal.find('.modal-footer button[type=submit]').text('Guardar cambios')
		title = 'Editar ubicación'
		var id = button.data('id')

		$.ajax({
			type: "POST",
			url: "peticiones.php",
			data: {id, accion:'obtener_ubicacion_by_id'},
			dataType: "json",
			cache: false,
			success: function(datos){
				if(datos.exitoso){
					modal.find('.modal-body input[name=id]').val(datos.id)
					modal.find('.modal-body input[name=departamento]').val(datos.departamento)
					modal.find('.modal-body input[name=pasillo]').val(datos.pasillo)
				}
			}
		})
	}
	
	modal.find('.modal-title').text(title)
})

$('#confDepartamentos').on('shown.bs.modal', function (event) {
	$(this).find("input[name=departamento]").focus().select();
})

$('#confSerCategoria').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var accion = button.data('accion')

	var modal = $(this)
	if(accion=='agregar'){
		title = 'Agregar Servicio'
		$("#formModal")[0].reset()
		modal.find('.modal-footer button[type=submit]').text('Guardar')
		modal.find('.modal-body input[name=accion]').val('registrar_ser_categoria')
	}else if(accion=='editar'){
		modal.find('.modal-body input[name=accion]').val('editar_ser_categoria')
		modal.find('.modal-footer button[type=submit]').text('Guardar cambios')
		title = 'Editar Servicio'
		var id = button.data('id')

		$.ajax({
			type: "POST",
			url: "peticiones.php",
			data: {id, accion:'obtener_ser_categoria_by_id'},
			dataType: "json",
			cache: false,
			success: function(datos){
				if(datos.exitoso){
					modal.find('.modal-body input[name=id]').val(datos.id)
					modal.find('.modal-body input[name=nombre]').val(datos.nombre)
					modal.find('.modal-body input[name=precio]').val(datos.precio)
				}
			}
		})
	}
	
	modal.find('.modal-title').text(title)
})

$('#confSerCategoria').on('shown.bs.modal', function (event) {
	$(this).find("input[name=nombre]").focus().select();
})

$('#confServicio').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var accion = button.data('accion')
	var tipo = button.data('tipo')

	var modal = $(this)
	if(accion=='agregar'){
		title = 'Agregar '+tipo
		$("#formModal")[0].reset()
		modal.find('.modal-footer button[type=submit]').text('Guardar')
		modal.find('.modal-body input[name=accion]').val('registrar_servicio')
	}else if(accion=='editar'){
		modal.find('.modal-body input[name=accion]').val('editar_servicio')
		modal.find('.modal-footer button[type=submit]').text('Guardar cambios')
		title = 'Editar '+tipo
		var id = button.data('id')

		$.ajax({
			type: "POST",
			url: "peticiones.php",
			data: {id, accion:'obtener_servicio_by_id'},
			dataType: "json",
			cache: false,
			success: function(datos){
				if(datos.exitoso){
					modal.find('.modal-body input[name=id]').val(datos.id)
					modal.find('.modal-body select[name=id_ubicacion]').val(datos.id_ubicacion)
					modal.find('.modal-body input[name=nombre]').val(datos.nombre)
					modal.find('.modal-body input[name=precio]').val(datos.precio)
					modal.find('.modal-body input[name=cantidad]').val(datos.cantidad)
				}
			}
		})
	}
	
	modal.find('.modal-title').text(title)
})

$('#confServicio').on('shown.bs.modal', function (event) {
	$(this).find("input[name=nombre]").focus().select();
})

$('#asociaServicio').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var id_ser_categoria = button.data('idsercategoria')

	var modal = $(this)
	title = 'Asociar Servicio'
	modal.find('.modal-title').text(title)
	modal.find('.modal-body input[name=id_ser_categoria]').val(id_ser_categoria)	
	modal.find('.modal-footer button[type=submit]').text('Asociar')
})

$('#confServiciosExtintor').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var index = button.data('index')

	var modal = $(this)
	modal.find('.modal-body input[name=index]').val(index)
})

$('#confServiciosExtintorEnTaller').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var id_nota_extintor = button.data('idnotaextintor')

	var modal = $(this)
	modal.find('.modal-body input[name=id_nota_extintor]').val(id_nota_extintor)
})

$('#verExtintores').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var id = button.data('id')

	$.ajax({
	    type: "POST",
	    url: "peticiones.php",
	    data:{id_nota: id, accion:'ver_extintores_nota'},
	    beforeSend: function(objeto){
	     	$("#ver_extintores_notas").html("<img src='images/white-loader.gif'/>");
	    },
	    success: function(datos){
	     	$("#ver_extintores_notas").html(datos);
	    }
	});
})

$('#verServicios').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var id_nota_extintor = button.data('id')

	$.ajax({
		type: "POST",
		url: "peticiones.php",
		data: {id_nota_extintor, accion:'verServicios_de_extintores'},
		success: function(datos){
			$("#recargar_servicios").html(datos)
		}
	})
})

$('#verServicios2').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var id_nota_extintor = button.data('id')

	$.ajax({
		type: "POST",
		url: "peticiones.php",
		data: {id_nota_extintor, accion:'verServicios_de_extintores2'},
		success: function(datos){
			$("#recargar_servicios").html(datos)
		}
	})
})

$('body').on('show.bs.modal', '#dar_de_baja', function (event) {
	var button = $(event.relatedTarget)
	var id_nota = button.data('id')
	
	var modal = $(this)
	modal.find('.modal-body input[name=id_nota]').val(id_nota)
	modal.find('.modal-title').text("Procesar nota #"+id_nota)
})

$('#confCategorias').on('show.bs.modal', function (event){

})

// FORMULARIO GENERAL
$('body').on('submit', '#formModal', function (event){
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
				alertify.alert('Mensaje', 'Registro exitoso!', function(){ 
					if(datos.refrescar){
						location.reload()
					}
					//ejecuta una accion devuelta segn la peticion
					switch(datos.ejecutar){
						case 'recargar_extintores':
							recargar_extintores(datos.id_ext_categoria)
						break;
						case 'cargar_serv_defecto':
							cargar_serv_defecto()
							$("#confServiciosExtintor").modal("hide")
						break;
					}
				})
			}else{
				alertify.alert('Mensaje', datos.error)
			}
		}
	})
	event.preventDefault();
})

$('body').on('submit', '#buscar_notas_por_estado', function (event){
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