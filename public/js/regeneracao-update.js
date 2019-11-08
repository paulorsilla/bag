    function refreshGridCaracteristica(id)
    {
        var url = "/bag/regeneracao-caracteristica/grid-modal?id="+id;
        $('#gridCaracteristica').load(url);
    }
    
    function refreshGridItem(id)
    {
        var url = "/bag/item-regeneracao/update-modal?id="+id;
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
    
    function selecionarMaterial()
    {
        var pesquisa = $("#pesquisa").val();
        alert(pesquisa);
    }
    
$(document).ready(function () {
    
});
