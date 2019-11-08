    function encerrarPedido(id)
    {
        var url = "/bag/pedido/close-modal?id="+id;
        $('#EncerrarModal .modal-body').html('carregando...');
        $('#EncerrarModal .modal-body').attr('url',url);
        $('#EncerrarModal .modal-body').load(url);
        $('#EncerrarModal').modal('show');
    }

    function fncEncerrarPedido(obj)
    {
        $(this).html("aguarde ...").attr("disabled",true);
        form =  $("form",$(obj).closest(".modal-content"));
        dados = $(form).serializeObject();
        urlPost = $(".modal-body",$(obj).closest(".modal-content")).attr('url');
        $.post(urlPost, dados, function(data){
            if ( data.success == 1 ){
                $("#EncerrarModal").modal('hide');
                window.location = "/bag/pedido";
            } else {
                $(".modal-body",$(obj).closest(".modal-content")).html(data);
            }
        });
    }
    
    function novoItem(pedidoId)
    {
        var pesquisaCgs = $("#pesquisaCgs").val().trim().replace(/ /g, '%20');
        var pesquisaAcesso = $("#pesquisaAcesso").val().trim().replace(/ /g, '%20');
        var pesquisaSinonimia = $("#pesquisaSinonimia").val().trim().replace(/ /g, '%20');
        if (pesquisaCgs === "" && pesquisaAcesso === "" && pesquisaSinonimia === "") {
            alert("Preencha algum campo de pesquisa para adicionar um novo material ao pedido.");
        } else {
            var url = "/bag/item-pedido/save-modal?pedidoId="+pedidoId+"&pesquisaCgs="+pesquisaCgs+"&pesquisaAcesso="+pesquisaAcesso+"&pesquisaSinonimia="+pesquisaSinonimia;
            $('#ItemModal .modal-body').html('carregando...');
            $('#ItemModal .modal-body').attr('url',url);
            $('#ItemModal .modal-body').load(url);
            $('#ItemModal').modal('show');
        }
    }
    
    function editarItem(id)
    {
        var url = "/bag/item-pedido/save-modal?id="+id;
        $('#ItemModal .modal-body').html('carregando...');
        $('#ItemModal .modal-body').attr('url',url);
        $('#ItemModal .modal-body').load(url);
        $('#ItemModal').modal('show');
    }

    function excluirItem(id)
    {
        var url = "/bag/item-pedido/delete-modal?id="+id;
        $('#ExclusaoItemModal .modal-body').html('carregando...');
        $('#ExclusaoItemModal .modal-body').attr('url',url);
        $('#ExclusaoItemModal .modal-body').load(url);
        $('#ExclusaoItemModal').modal('show');
    }
    
    function refreshGridItem(id)
    {
        var url = "/bag/item-pedido/grid-modal?id="+id;
        $('#gridItem').load(url);
    }
    
    function fncExcluirItem(obj)
    {
        $(this).html("aguarde ...").attr("disabled",true);
        form =  $("form",$(obj).closest(".modal-content"));
        dados = $(form).serializeObject();
        urlPost = $(".modal-body",$(obj).closest(".modal-content")).attr('url');
        $.post(urlPost, dados, function(data){
            if ( data.success == 1 ){
                $("#ExclusaoItemModal").modal('hide');
                refreshGridItem(data.pedidoId);
            } else {
                $(".modal-body",$(obj).closest(".modal-content")).html(data);
            }
        });
    }
    
    function fncSalvarItem(obj)
    {
        $(this).html("aguarde ...").attr("disabled",true);
        var form =  $("form",$(obj).closest(".modal-content"));
        var dados = $(form).serializeObject();
        
        var urlPost = $(".modal-body",$(obj).closest(".modal-content")).attr('url');
        
        $.post(urlPost, dados, function(data){
            if ( data.success == 1 ) {
                $("#ItemModal").modal('hide');
                refreshGridItem(data.pedidoId);
            } else {
                $(".modal-body",$(obj).closest(".modal-content")).html(data);
            }
            $(this).html("Salvar").removeAttr("disabled");
        });
    } 
    function mascarasEntrada()
    {
//        $("#pesoSem").inputmask("999.999.999,99");
//        $("#cep").inputmask("99999-999");
    }

    
$(document).ready(function () {
    
    $("#fileAtm").change(function() {
        var fileNameAux = $(this).val().replace(/C:\\fakepath\\/i, '');
        var fileName = fileNameAux.replace(/\s/g, '_');
        var formData = new FormData();
        formData.append('pedidoId', $("#pedidoId").val());
        formData.append('arquivo', $("#fileAtm")[0].files[0]);

        $.ajax({
            url: '/bag/pedido/attach-atm',
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            success: function() {
                $("#anexoAtm").val(fileName);
            }
        });
    });
    
    $("#fileAtm").hide();
    
    $("#uploadAtm").click(function(e) {
        e.preventDefault();
        $("#fileAtm").trigger("click");
    });
    
//    $("#tipo").select2({
//        placeholder: "Selecione o destino",
//        allowClear: true
//    });

    $("#instituicao").select2({
        placeholder: "Selecione a instituição",
        allowClear: true
    });

    
    $("#ItemModal").on("shown.bs.modal", function() {
        
        $("#material").select2({
            placeholder: "CGS - Acesso (selecione)",
            allowClear: true
        });
        
        $("#material").focus();
        
        $("#material").change(function() {
            $.ajax({
                url: '/bag/material/busca-saldo?id='+$(this).val(),
                type: 'get',
                success: function(d) {
                    $("#quantidadeAtual").val(d.quantidadeAtual);
                }
            });
        });

    });
    
});
