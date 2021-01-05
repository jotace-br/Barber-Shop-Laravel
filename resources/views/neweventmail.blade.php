<body>
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <header class="container">
      <h1>Aviso de evento</h1>
  </header>
  <div class="underbar"></div>
  <section class="container situacao">
    <div class="text">
      <p>Evento: <b>{{ $title }}</b></p>
      <p>Tipo do Evento: <b>{{ $event_type }}</b>.</p>
      <p class="sub">Você foi convocado para esse evento por <b>{{ $fk_user }}</b>.</p>
    </div>

  </section>
  <footer class="container">
    <b>Plataforma Internacional</b>
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

  p{
    overflow-wrap: break-word;
    margin-bottom: 8px
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
    font-size: 1.6rem;
  }
  .text{
    margin-bottom: 12vh;
    text-align: left;
    width: 75%;
  }
  .sub{
    font-size: 1.3rem;
    opacity: 0.7;
    margin-top: 4px ;
  }
  footer{
    height: 10vh;
    background-color: #348E53;
    color: #F3F5F7;
  }
</style>
