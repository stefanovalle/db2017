<!DOCTYPE html>
<html>
  <head>
    <title>MV chocosite</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
  </head>
  <body>
    <?php include 'include/header.php'; ?>
    <main>
      <div class="row">
        <div class="col-md-12">
          <h1>Iscrizione nuovo utente</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">

          <form method="POST" action="esegui_iscrizione.php">
            <div class="form-group">
              <label for="nome">Nome</label>
              <input type="text" class="form-control" name="nome" placeholder="nome">
            </div>
            <div class="form-group">
              <label for="cognome">Cognome</label>
              <input type="text" class="form-control" name="cognome" placeholder="cognome">
            </div>
            <div class="form-group">
              <label for="email">Indirizzo email</label>
              <input type="email" class="form-control" name="email" placeholder="email">
            </div>
            <div class="form-group">
              <label for="indirizzo">Indirizzo</label>
              <input type="text" class="form-control" name="indirizzo" placeholder="indirizzo">
            </div>
            <div class="form-group">
              <label for="citta">Città</label>
              <input type="text" class="form-control" name="citta" placeholder="citta">
            </div>
            <div class="form-group">
              <label for="cap">CAP</label>
              <input type="text" class="form-control" name="cap" placeholder="cap">
            </div>
            <div class="form-group">
              <label for="provincia">Provincia</label>
              <select name="provincia" class="form-control">
                <option>GO</option>
                <option>PN</option>
                <option>UD</option>
                <option>TS</option>
              </select>
            </div>
            <div class="form-group">
              <label for="note">Note</label>
              <textarea name="note" class="form-control" rows="3"></textarea>
            </div>
            <div class="checkbox">
              <label>
                <input type="checkbox" name="privacy"> Acconsento al trattamento dati
              </label>
            </div>
            <button type="submit" class="btn btn-primary">Continua</button>
          </form>

        </div>
      </div>
    </main>
    <?php include 'include/footer.php'; ?>
  </body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="/js/bootstrap.min.js"></script>
</html>
