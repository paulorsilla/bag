function caracteristicas(txtCaracteristicas, options) {
    var listaCaracteristicas = txtCaracteristicas.split(";");
    var selectTemplate =  "<label for='coluna-SELECTID'>-SELECTID</label><select id='coluna-SELECTID' class='form-control' name='coluna-SELECTID'>"+options+"</select>";
    $.each(listaCaracteristicas, function(id, caracteristica) {
        if (caracteristica !== '') {
            var select = selectTemplate.replace(/-SELECTID/g, caracteristica);
            $("#descritores").append("<div id='descritor_"+id+"' class='col-md-3'>"+select+"</div>");
        }
    });
}

function selecaoAutomatica() {
    
    $("#colunaCgs").find('option').each(function() {
        var textoAux  = $(this).text().replace("-","§").split("§", 2);
        var texto = textoAux[1].trim().toUpperCase().replace("ÇÃ","CA");
        var valor = $(this).val();
        $("select[name^='coluna']").each(function() {
            var nomeSelect = $(this).attr('id').replace('coluna', '').trim().toUpperCase();
            if (nomeSelect === texto) {
                $(this).val(valor);
                return true;
            }
        });
    });
}

function preprocessamento() {
    var nomeArquivo = $("#nomeArquivo").val();
    var colunaCgs = $("#colunaCgs").val();
    var colunaAcesso = $("#colunaAcesso").val();
    if (nomeArquivo !== '') {
        $.ajax({
            method: 'post',
            type: 'post',
            url: '/bag/importacao-caderneta/preprocessamento',
            data: {nomeArquivo:nomeArquivo, colunaCgs:colunaCgs, colunaAcesso:colunaAcesso},
            success: function(d) {
                $("#resultadopreprocessamento").html("<div class='col-md-12'>"+d.naoEncontrados+"</div>");
            }
        });
    }
}

$(document).ready(function () {
    
    $("#fileUpload").change(function() {
        var fileNameAux = $(this).val().replace(/C:\\fakepath\\/i, '');
        var fileName = fileNameAux.replace(/\s/g, '_');
        var formData = new FormData();
//        formData.append('pedidoId', $("#pedidoId").val());
        formData.append('arquivo', $("#fileUpload")[0].files[0]);
        $.ajax({
            method: 'post',
            type: 'post',
            url: '/bag/importacao-caderneta/attachfile',
            data: formData,
            processData: false,
            contentType: false,
            success: function(d) {
                $("#nomeArquivo").val(fileName);
                $("select[name^='coluna']").html(d.options);
                caracteristicas(d.caracteristicas, d.options);
                selecaoAutomatica();
            }
        });
    });
    
    $("#fileUpload").hide();
    
    $("#uploadArquivo").click(function(e) {
        e.preventDefault();
        $("#fileUpload").trigger("click");
    });
    
//    $("#instituicao").select2({
//        placeholder: "Selecione a instituição",
//        allowClear: true
//    });
    
});
