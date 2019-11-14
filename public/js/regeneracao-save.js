    function encerrarCadastroMaterial(id)
    {
        var url = "/bag/regeneracao/close-modal?id="+id;
        $('#EncerrarModal .modal-body').html('carregando...');
        $('#EncerrarModal .modal-body').attr('url',url);
        $('#EncerrarModal .modal-body').load(url);
        $('#EncerrarModal').modal('show');
    }

    function fncEncerrarCadastroMaterial(obj)
    {
        $(this).html("aguarde ...").attr("disabled",true);
        form =  $("form",$(obj).closest(".modal-content"));
        dados = $(form).serializeObject();
        urlPost = $(".modal-body",$(obj).closest(".modal-content")).attr('url');
        $.post(urlPost, dados, function(data){
            if ( data.success == 1 ){
                $("#EncerrarModal").modal('hide');
                window.location = "/bag/regeneracao";
            } else {
                $(".modal-body",$(obj).closest(".modal-content")).html(data);
            }
        });
    }
    
    function novaCaracteristica(regeneracaoId)
    {
        var url = "/bag/regeneracao-caracteristica/save-modal?regeneracaoId="+regeneracaoId;
        $('#CaracteristicaModal .modal-body').html('carregando...');
        $('#CaracteristicaModal .modal-body').attr('url',url);
        $('#CaracteristicaModal .modal-body').load(url);
        $('#CaracteristicaModal').modal('show');
    }
    
    function excluirCaracteristica(idRegeneracao, idCaracteristica)
    {
        var url = "/bag/regeneracao-caracteristica/delete-modal?idRegeneracao="+idRegeneracao+"&idCaracteristica="+idCaracteristica;
        $('#ExclusaoCaracteristicaModal .modal-body').html('carregando...');
        $('#ExclusaoCaracteristicaModal .modal-body').attr('url',url);
        $('#ExclusaoCaracteristicaModal .modal-body').load(url);
        $('#ExclusaoCaracteristicaModal').modal('show');
    }
    
    function refreshGridCaracteristica(id)
    {
        var url = "/bag/regeneracao-caracteristica/grid-modal?id="+id;
        $('#gridCaracteristica').load(url);
    }
    
    function fncExcluirCaracteristica(obj)
    {
        $(this).html("aguarde ...").attr("disabled",true);
        form =  $("form",$(obj).closest(".modal-content"));
        dados = $(form).serializeObject();
        urlPost = $(".modal-body",$(obj).closest(".modal-content")).attr('url');
        $.post(urlPost, dados, function(data){
            if ( data.success == 1 ){
                $("#ExclusaoCaracteristicaModal").modal('hide');
                refreshGridCaracteristica(data.regeneracaoId);
            } else {
                $(".modal-body",$(obj).closest(".modal-content")).html(data);
            }
        });
    }
    
    function fncSalvarCaracteristica(obj)
    {
        $(this).html("aguarde ...").attr("disabled",true);
        var form =  $("form",$(obj).closest(".modal-content"));
        var dados = $(form).serializeObject();
        
        var urlPost = $(".modal-body",$(obj).closest(".modal-content")).attr('url');
        
        $.post(urlPost, dados, function(data){
            if ( data.success == 1 ) {
                $("#CaracteristicaModal").modal('hide');
                refreshGridCaracteristica(data.regeneracaoId);
            } else {
                $(".modal-body",$(obj).closest(".modal-content")).html(data);
            }
            $(this).html("Salvar").removeAttr("disabled");
        });
    } 
    
    function novoItem(regeneracaoId)
    {
        var pesquisaCgs = $("#pesquisaCgs").val().trim().replace(/ /g, '%20');
        var pesquisaAcesso = $("#pesquisaAcesso").val().trim().replace(/ /g, '%20');
        var pesquisaSinonimia = $("#pesquisaSinonimia").val().trim().replace(/ /g, '%20');
        var url = "/bag/item-regeneracao/save-modal?regeneracaoId="+regeneracaoId+"&pesquisaCgs="+pesquisaCgs+"&pesquisaAcesso="+pesquisaAcesso+"&pesquisaSinonimia="+pesquisaSinonimia;
        $('#ItemModal .modal-body').html('carregando...');
        $('#ItemModal .modal-body').attr('url',url);
        $('#ItemModal .modal-body').load(url);
        $('#ItemModal').modal('show');
    }
    
    function editarItem(id)
    {
        var url = "/bag/item-regeneracao/save-modal?id="+id;
        $('#ItemModal .modal-body').html('carregando...');
        $('#ItemModal .modal-body').attr('url',url);
        $('#ItemModal .modal-body').load(url);
        $('#ItemModal').modal('show');
    }

    function excluirItem(id)
    {
        var url = "/bag/item-regeneracao/delete-modal?id="+id;
        $('#ExclusaoItemModal .modal-body').html('carregando...');
        $('#ExclusaoItemModal .modal-body').attr('url',url);
        $('#ExclusaoItemModal .modal-body').load(url);
        $('#ExclusaoItemModal').modal('show');
    }
    
    function refreshGridItem(id)
    {
        var url = "/bag/item-regeneracao/grid-modal?id="+id;
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
                refreshGridItem(data.regeneracaoId);
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
                refreshGridItem(data.regeneracaoId);
            } else {
                $(".modal-body",$(obj).closest(".modal-content")).html(data);
            }
            $(this).html("Salvar").removeAttr("disabled");
        });
    } 
    
    function fcnImportar(id)
    {
        $.ajax({
           type: "POST",
           url: "/bag/regeneracao/importar",
           data: {regeneracaoId:id},
           success: function(d) {
               alert("Sucesso");
//               refreshGridItem(regeneracaoId);
           }
        });
    }
    
    function novasCaracteristicasRotina(id) {
        $.ajax({
           type: "POST",
           url: "/bag/regeneracao/incluir-caracteristica-rotina",
           data: {regeneracaoId:id},
           success: function() {
                refreshGridCaracteristica(id);
           }
        });
    }
    
    function novasCaracteristicasPlanilha(caracteristicas) {
        var regeneracaoId = $("#idRegeneracao").val();
        $.ajax({
           type: "POST",
           url: "/bag/regeneracao/incluir-caracteristica-planilha",
           data: {regeneracaoId:regeneracaoId,caracteristicas:caracteristicas},
           success: function() {
                refreshGridCaracteristica(regeneracaoId);
           }
        });
    }
    
    function selecaoAutomatica() {
        $("#colunaCgs").find('option').each(function() {
            var textoAux  = $(this).text().replace("-","§").split("§", 2);
            var texto = textoAux[1].trim().toUpperCase().replace("ÇÃ","CA");
            if (texto === "BAGCOD") {
                texto = "CGS";
            }
            var valor = $(this).val();
            $("select[name^='coluna']").each(function() {
                var nomeSelect = $(this).attr('id').replace('coluna', '').trim().toUpperCase();
                if (nomeSelect === "DATAPLANTIO") {
                    nomeSelect = "DATA PLANTIO";
                }
                if (nomeSelect === texto) {
                    $(this).val(valor);
                    return true;
                }
            });
        });
    }
    
$(document).ready(function () {
    
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
    
    $("#fileUpload").change(function() {
        var fileNameAux = $(this).val().replace(/C:\\fakepath\\/i, '');
        var fileName = fileNameAux.replace(/\s/g, '_');
        var formData = new FormData();
        formData.append('arquivo', $("#fileUpload")[0].files[0]);
        $.ajax({
            method: 'post',
            type: 'post',
            url: '/bag/regeneracao/attachfile',
            data: formData,
            processData: false,
            contentType: false,
            success: function(d) {
                novasCaracteristicasPlanilha(d.caracteristicas);
                refreshGridCaracteristica($("#idRegeneracao").val());

                $("#nomeArquivo").val(fileName);
                $("select[name^='coluna']").html(d.options);
                selecaoAutomatica();
                
            }
        });
    });
    
    $("#fileUpload").hide();
    
    $("#uploadArquivo").click(function(e) {
        e.preventDefault();
        $("#fileUpload").trigger("click");
    });
    
});
