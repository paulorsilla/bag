    function editarBag(materialId)
    {
        var url = "/bag/bag/save-modal?materialId="+materialId;
        $('#BagModal .modal-body').html('carregando...');
        $('#BagModal .modal-body').attr('url',url);
        $('#BagModal .modal-body').load(url);
        $('#BagModal').modal('show');
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
//                refreshGridBag(data.materialId);
            } else {
                $(".modal-body",$(obj).closest(".modal-content")).html(data);
            }
            $(this).html("Salvar").removeAttr("disabled");
            document.location.href = '/bag/bag';
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


$(document).ready(function () {

    var selecao = $("#selecao").val();
    if (selecao !== "0") {
        editarBag(selecao);
    }
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
