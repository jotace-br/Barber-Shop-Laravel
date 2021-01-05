<body>
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <header class="container">
      <h1>Requisição de compra</h1>
  </header>
  <div class="underbar"></div>
  <section class="container situacao">
    <div class="text">
      <p>Olá, <b> {{ $name }} {{ $surname }}</b>!</p>
      <br>
      <p>A sua requisição de {{ $quantity }} un. de {{ $request_name }} feita na data {{ $request_date }} está no momento como: <b>{{ $request_stage }}</b>.</p>
      <br>
      @if ($reason)
        <p>Motivo: <u>{{ $reason }}</u>.</p>
      @endif
      <br>
    </div>

  </section>
  <footer class="container">
    <b>Plataforma Internacional.</b>
  </footer>
</body>

<style>
  *{
    margin: 0;
    padding: 0;
    border: 0;
    box-sizing: border-box;
  }
  body{
    width: 100vw;
    margin: auto;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
  }
  .container{
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    flex-direction: column;
  }


  header {
    height: 15vh;
    background-color: #52BC77;
    color: #F3F5F7;
  }
  .underbar{
    height: 2.5vh;
    background-color: #87D3A2;
  }
  .situacao{
    height: 72.5vh;
    background-color: #f5f5f5;
    color: #242424;
    font-size: 2rem;
  }
  .text{
    margin-bottom: 12vh;
  }
  footer{
    height: 10vh;
    background-color: #348E53;
    color: #F3F5F7;
  }


</style>
