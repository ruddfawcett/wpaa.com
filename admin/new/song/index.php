<!DOCTYPE HTML>
<html>
  <head>
    <style>
      * {
        margin: 0;
        padding: 0;
      }

      body {
        background-color: #EEE;
        font-family: sans-serif;
      }

      .form {
        width: 60%;
        margin: 0 auto;
        padding: 20px 10%;
        background-color: white;
        /*-webkit-box-shadow: 0px 0px 108px -12px rgba(0,0,0,0.63);
        -moz-box-shadow: 0px 0px 108px -12px rgba(0,0,0,0.63);
        box-shadow: 0px 0px 108px -12px rgba(0,0,0,0.63);*/
      }

      .form h2 {
        margin: 10px 0 40px 0;
      }

      .form h2 span.right {
        float: right;
        text-transform: uppercase;
        font-size: 15px;x
      }

      .items {
        margin-left: auto;
        margin-right: auto;
      }

      .items input[type='text'] {
        border: none;
        background: #494949;
        color: #FFF;
        padding: 7px;
        font-size: 22px;
        width: 80%
      }

      .items input[type='submit'] {
        border: none;
        background: #949494;
        color: #FFF;
        padding: 7px 10px;
        width: 15%;
        font-size: 22px;
      }

      .results {
        padding-top: 30px;
        min-height: 20px;
      }

      span.gray {
        color: #949494;
      }

      ol li {
        padding: 10px;
      }

      ol li:nth-child(odd) {
        background-color: #EEE;
      }
    </style>
  </head>
  <body>
    <?php
      error_reporting(0);
    ?>
    <div class='form'>
      <h2><span class='gray'>Current Show:</span> <?php echo "this Show"; ?><a href='../show/'><span class='right'>New Show</span></a></h2>

      <form action='' method='get'>
        <div class='items'>
          <input type='text' name='q' placeholder='Search for a song...'><input type='submit'>
        </div>
        <div class='results'>
          <?php
            if (array_key_exists('q', $_GET)) {
              echo '<h2 class="gray">Results</h2>';
              $context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
              $url = 'http://musicbrainz.org/ws/2/release/?query=release:'.urlencode($_GET['q']);

              $xml = file_get_contents($url, false, $context);
              $xml = simplexml_load_string($xml);
              $json = json_encode($xml);
              $results = json_decode($json, true);
              $results = $results['release-list']['release'];
              echo '<ol>';
              foreach ($results as $result) {
                echo '<li><b>'.$result['title'].'</b> by '.$result['artist-credit']['name-credit']['artist']['name'].' &mdash; Released '.$result['date'].'</li>';
              }
              echo '</ol>';
            }
          ?>
        </div>
      </form>
    </div>
  </body>
</html>
