<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
    
    <style>
        @import url(https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;1,300&display=swap);
        @import url(https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css);
    
        html, body, html * {
        font-family: 'Roboto', sans-serif;
        }       
        p {
            text-align:left;
            font-size: 14px;
            font-family: 'Roboto', sans-serif
        }
        b {
            text-transform: uppercase;
        }
        
        .l{
            width:50%;
            float: left;
        }
        .r {
            width:50%;
            float: left;
        }
        h1 {
            text-align: center;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div id="event-create-container" class="col-md-6 offset-md-3">
        <div class="form-group">
            <h1>PREVISAO DE CUSTOS</h1>
        </div>
        <div class="form-group">
            <p>PACIENTE: <b>{{ $orcamento->paciente }}</b></p>
            <p>CONVENIO: <b>{{ $orcamento->convenios }}</b></p>
            <p>CIRURGIAO: <b>{{ $orcamento->medico }}</b></p>
        </div>
        <div>
    </div>
    <div class="form-group">
        <label for="title">01 - Procedimento</label>
        <p>{{ $orcamento->procedimento }}</p>
    </div>
    <div class="form-group">
    <label for="title" >02 - Cirurgiao</label>
    </div>
    <div class="form-group l">
    <p>Honorario medico cirurgião<br/>Pagamento em 8X no cartao, ou cheque a vista</p>
    </div>
    <div class="form-group r">
        <p style="text-align: right; margin-top: 25px; margin-right: 25px">{{ $orcamento->preco_medico}}</p> 
    </div>

    <div class="form-group">
    <label for="title" >03 - Instrumentação Cirurgica e Suporte</label>
    </div>
    <div class="form-group l">
    <p>Honorario Instrumentador Cirurgico 10% valor Cirurgião<br/>A vista, no ato da internação pix, deposito ou dinheiro</p>
    </div>
    <div class="form-group r">
        <p style="text-align: right; margin-top: 25px; margin-right: 25px">{{ $orcamento->venda_equipe}}</p> 
    </div>
</body>
</html>