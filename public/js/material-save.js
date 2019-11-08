    function novoPassaporte(materialId)
    {
        var url = "/bag/passaporte/save-modal?materialId="+materialId;
        $('#PassaporteModal .modal-body').html('carregando...');
        $('#PassaporteModal .modal-body').attr('url',url);
        $('#PassaporteModal .modal-body').load(url);
        $('#PassaporteModal').modal('show');
    }
    
    function editarPassaporte(materialId)
    {
        var url = "/bag/passaporte/save-modal?materialId="+materialId;
        $('#PassaporteModal .modal-body').html('carregando...');
        $('#PassaporteModal .modal-body').attr('url',url);
        $('#PassaporteModal .modal-body').load(url);
        $('#PassaporteModal').modal('show');
    }

    function excluirPassaporte(materialId)
    {
        var url = "/bag/passaporte/delete-modal?materialId="+materialId;
        $('#ExclusaoPassaporteModal .modal-body').html('carregando...');
        $('#ExclusaoPassaporteModal .modal-body').attr('url',url);
        $('#ExclusaoPassaporteModal .modal-body').load(url);
        $('#ExclusaoPassaporteModal').modal('show');
    }
    
    function refreshGridPassaporte(id)
    {
        var url = "/bag/passaporte/grid-modal?id="+id;
        $('#gridPassaporte').load(url);
    }
    
    function fncExcluirPassaporte(obj)
    {
        $(this).html("aguarde ...").attr("disabled",true);
        form =  $("form",$(obj).closest(".modal-content"));
        dados = $(form).serializeObject();
        urlPost = $(".modal-body",$(obj).closest(".modal-content")).attr('url');
        $.post(urlPost, dados, function(data){
            if ( data.success == 1 ){
                $("#ExclusaoPassaporteModal").modal('hide');
                refreshGridPassaporte(data.materialId);
            } else {
                $(".modal-body",$(obj).closest(".modal-content")).html(data);
            }
        });
    }
    
    function fncSalvarPassaporte(obj)
    {
        $(this).html("aguarde ...").attr("disabled",true);
        var form =  $("form",$(obj).closest(".modal-content"));
        var dados = $(form).serializeObject();
        
        var urlPost = $(".modal-body",$(obj).closest(".modal-content")).attr('url');
        
        $.post(urlPost, dados, function(data){
            if ( data.success == 1 ) {
                $("#PassaporteModal").modal('hide');
                refreshGridPassaporte(data.materialId);
            } else {
                $(".modal-body",$(obj).closest(".modal-content")).html(data);
            }
            $(this).html("Salvar").removeAttr("disabled");
        });
    }
    
    function refreshGridImagens(id)
    {
        var url = "/bag/imagem/grid-modal?id="+id;
        $('#gridImagens').load(url);
    }
    
    function novaCaracteristica(materialId)
    {
        var url = "/bag/material-caracteristica/save-modal?materialId="+materialId;
        $('#CaracteristicaModal .modal-body').html('carregando...');
        $('#CaracteristicaModal .modal-body').attr('url',url);
        $('#CaracteristicaModal .modal-body').load(url);
        $('#CaracteristicaModal').modal('show');
    }
    
    function editarCaracteristica(id)
    {
        var url = "/bag/material-caracteristica/save-modal?id="+id;
        $('#CaracteristicaModal .modal-body').html('carregando...');
        $('#CaracteristicaModal .modal-body').attr('url',url);
        $('#CaracteristicaModal .modal-body').load(url);
        $('#CaracteristicaModal').modal('show');
    }

    function excluirCaracteristica(id)
    {
        var url = "/bag/material-caracteristica/delete-modal?id="+id;
        $('#ExclusaoCaracteristicaModal .modal-body').html('carregando...');
        $('#ExclusaoCaracteristicaModal .modal-body').attr('url',url);
        $('#ExclusaoCaracteristicaModal .modal-body').load(url);
        $('#ExclusaoCaracteristicaModal').modal('show');
    }
    
    function refreshGridCaracteristica(materialId)
    {
        var url = "/bag/material-caracteristica/grid-modal?materialId="+materialId;
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
                refreshGridCaracteristica(data.materialId);
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
        
        $.post(urlPost, dados, function(data) {
            if ( data.success == 1 ) {
                $("#CaracteristicaModal").modal('hide');
                refreshGridCaracteristica(data.materialId);
            } else {
                $(".modal-body",$(obj).closest(".modal-content")).html(data);
            }
            $(this).html("Salvar").removeAttr("disabled");
        });
    } 

    function novoBag(materialId)
    {
        var url = "/bag/bag/save-modal?materialId="+materialId;
        $('#BagModal .modal-body').html('carregando...');
        $('#BagModal .modal-body').attr('url',url);
        $('#BagModal .modal-body').load(url);
        $('#BagModal').modal('show');
    }
    
    function editarBag(materialId)
    {
        var url = "/bag/bag/save-modal?materialId="+materialId;
        $('#BagModal .modal-body').html('carregando...');
        $('#BagModal .modal-body').attr('url',url);
        $('#BagModal .modal-body').load(url);
        $('#BagModal').modal('show');
    }

    function excluirBag(materialId)
    {
        var url = "/bag/bag/delete-modal?materialId="+materialId;
        $('#ExclusaoBagModal .modal-body').html('carregando...');
        $('#ExclusaoBagModal .modal-body').attr('url',url);
        $('#ExclusaoBagModal .modal-body').load(url);
        $('#ExclusaoBagModal').modal('show');
    }
    
    function refreshGridBag(id)
    {
        var url = "/bag/bag/grid-modal?id="+id;
        $('#gridBag').load(url);
    }
    
    function fncExcluirBag(obj)
    {
        $(this).html("aguarde ...").attr("disabled",true);
        form =  $("form",$(obj).closest(".modal-content"));
        dados = $(form).serializeObject();
        urlPost = $(".modal-body",$(obj).closest(".modal-content")).attr('url');
        $.post(urlPost, dados, function(data){
            if ( data.success == 1 ) {
                $("#ExclusaoBagModal").modal('hide');
                refreshGridBag(data.materialId);
            } else {
                $(".modal-body",$(obj).closest(".modal-content")).html(data);
            }
        });
    }
    
    function fncSalvarBag(obj)
    {
        $(this).html("aguarde ...").attr("disabled",true);
        var form =  $("form",$(obj).closest(".modal-content"));
        var dados = $(form).serializeObject();
        var urlPost = $(".modal-body",$(obj).closest(".modal-content")).attr('url');
        $.post(urlPost, dados, function(data){
            if ( data.success == 1 ) {
                $("#BagModal").modal('hide');
                refreshGridBag(data.materialId);
            } else {
                $(".modal-body",$(obj).closest(".modal-content")).html(data);
            }
            $(this).html("Salvar").removeAttr("disabled");
        });
    } 
    
    function novoTipoBag(materialId)
    {
        var url = "/bag/material-tipo-bag/save-modal?materialId="+materialId;
        $('#TipoBagModal .modal-body').html('carregando...');
        $('#TipoBagModal .modal-body').attr('url',url);
        $('#TipoBagModal .modal-body').load(url);
        $('#TipoBagModal').modal('show');
    }
    
    function editarTipoBag(id)
    {
        var url = "/bag/material-tipo-bag/save-modal?id="+id;
        $('#TipoBagModal .modal-body').html('carregando...');
        $('#TipoBagModal .modal-body').attr('url',url);
        $('#TipoBagModal .modal-body').load(url);
        $('#TipoBagModal').modal('show');
    }

    function excluirTipoBag(id)
    {
        var url = "/bag/material-tipo-bag/delete-modal?id="+id;
        $('#ExclusaoTipoBagModal .modal-body').html('carregando...');
        $('#ExclusaoTipoBagModal .modal-body').attr('url',url);
        $('#ExclusaoTipoBagModal .modal-body').load(url);
        $('#ExclusaoTipoBagModal').modal('show');
    }
    
    function refreshGridTipoBag(materialId)
    {
        var url = "/bag/material-tipo-bag/grid-modal?materialId="+materialId;
        $('#gridTipoBag').load(url);
    }
    
    function fncExcluirTipoBag(obj)
    {
        $(this).html("aguarde ...").attr("disabled",true);
        form =  $("form",$(obj).closest(".modal-content"));
        dados = $(form).serializeObject();
        urlPost = $(".modal-body",$(obj).closest(".modal-content")).attr('url');
        $.post(urlPost, dados, function(data){
            if ( data.success == 1 ){
                $("#ExclusaoTipoBagModal").modal('hide');
                refreshGridTipoBag(data.materialId);
            } else {
                $(".modal-body",$(obj).closest(".modal-content")).html(data);
            }
        });
    }
    
    function fncSalvarTipoBag(obj)
    {
        $(this).html("aguarde ...").attr("disabled",true);
        var form =  $("form",$(obj).closest(".modal-content"));
        var dados = $(form).serializeObject();
        
        var urlPost = $(".modal-body",$(obj).closest(".modal-content")).attr('url');
        
        $.post(urlPost, dados, function(data) {
            if ( data.success == 1 ) {
                $("#TipoBagModal").modal('hide');
                refreshGridTipoBag(data.materialId);
            } else {
                $(".modal-body",$(obj).closest(".modal-content")).html(data);
            }
            $(this).html("Salvar").removeAttr("disabled");
        });
    } 
    
    function montaCombo(lados, faces, niveis, espacos)
    {
        var option = "<option value=''>Selecione</option>";
        var optionLados = option;
        var optionLD = "<option value='D'>Direito</option>";
        var optionLE = "<option value='E'>Esquerdo</option>";
        if (lados === 1) {
            optionLados += optionLD + optionLE;
        } else if (lados === 2) {
            optionLados += optionLD;
        } else {
            optionLados += optionLE;
        }
        $("#lado").html(optionLados);
        
        var optionFaces = option;
        for(var i = 1; i <= faces; i++) {
            optionFaces += "<option value='"+i+"'>"+i+"</option>";
        }
        $("#face").html(optionFaces);
        
        var optionNiveis = option;
        for (var i = 1; i <= niveis; i++) {
            var j = i;
            if (i < 10) {
                j = '0'+i;
            }
            optionNiveis += "<option value='"+j+"'>"+j+"</option>";
        }
        $("#nivel").html(optionNiveis);
        
        var optionEspacos = option;
        for (var i = 1; i <= espacos; i++ ) {
            var j = i;
            if (i < 10) {
                j = '0'+i;
            }
            optionEspacos += "<option value='"+j+"'>"+j+"</option>";
        }
        $("#espaco").html(optionEspacos);
    }
    
    function criaLocalizacao() 
    {
        var modulo = $("#modulo").val();
        var lado = $("#lado").val();
        var face = $("#face").val();
        var nivel = $("#nivel").val();
        var espaco = $("#espaco").val();
        
        var localizacao = "";
        if  (modulo !== '' && lado !== '' && face !== '' && nivel !== '' && espaco !== '') { 
            localizacao = "M"+modulo+"."+lado+".F"+face+"."+nivel+"."+espaco;
        }
        $("#localizacao").val(localizacao);
    }
    
    function atualizaSaldo() {
        var pesoSem = $("#pesoSem").inputmask('unmaskedvalue')/100;
        if (pesoSem !== 0) {
            var pesoTotal = $("#pesoTotal").inputmask('unmaskedvalue')/100;
            var saldo = pesoTotal * 100 / pesoSem;
            saldo = saldo.toFixed(2).replace(".",",");
        } else {
            saldo = 0;
        } 
        $("#saldo").val(saldo);
    }
    
    function atualizaPeso100() {
        var peso = $("#peso").inputmask('unmaskedvalue');
        var multiplicador = $("#multiplicador").val();
        var peso100 = peso * multiplicador;
        $("#pesoSem").val(peso100);
        atualizaSaldo();
    }
    
$(document).ready(function () {

    $("#file").hide();
    $("#BagModal").on("shown.bs.modal", function() {
        
        $("#peso").inputmask("999999,99", {numericInput: true, positionCaretOnTab: false});
        $("#pesoSem").inputmask("999999,99", {numericInput: true, positionCaretOnTab: false});
        $("#pesoTotal").inputmask("999999,99", {numericInput: true, positionCaretOnTab: false});
        atualizaSaldo();

        $("#safra").focusin(function() {
           $(this).select();
        });
        
        $("#safra").focus();

        $("#modulo").change(function() {
            $.ajax({
                type: "POST",
                url: "/bag/modulo/consulta",
                data: {id:$(this).val()},
                success: function(d) {
                    montaCombo(d.lados, d.faces, d.niveis, d.espacos);
                    criaLocalizacao();
                },
                dataType: "json"
            });
        });
        $("#lado").change(function() {
            criaLocalizacao();
        });
        $("#face").change(function() {
            criaLocalizacao();
        });
        $("#nivel").change(function() {
            criaLocalizacao();
        });
        $("#espaco").change(function() {
            criaLocalizacao();
        });
        
        $("#peso").change(function() {
           atualizaPeso100(); 
        });

        $("#multiplicador").change(function() {
           atualizaPeso100(); 
        });
        
        $("#pesoSem").change(function() {
           atualizaSaldo(); 
        });
        
        $("#pesoTotal").change(function() {
           atualizaSaldo(); 
        });
    });
});
