<?php
set_time_limit(10);

function fattoriale($n=0) {
  if($n<=0) return 1;
  return fattoriale($n-1)*$n;
}

define("COMUNICHE",0);
define("su",0);
define("giu",1);
define("dx",2);
define("sx",3);
class ilgiocodel15 {
    var $ordine;
    var $tabella;
    var $ultimo_numero;
  //-------------------------------------------------------------------------------------------\\
  function ilgiocodel15() {
    $this->ordine=4;
    $this->crea();
    $this->ultimo_numero=0;
  }
  //-------------------------------------------------------------------------------------------\\
  function crea() {
    //crea l'array con i 15 numeri
    $this->tabella=range(1,15);
    //crea la cella vuota
    $this->tabella[]=null;
    do {
      //inizializza il seme x il random
      srand((float)microtime() * 1000000);
      $volte=rand(1,10);
      if(COMUNICHE) echo "<h3>quante volte lo mischio? $volte</h3>";
      //creo <volte> l'array mischiato
      if(COMUNICHE) echo "<pre>";
      while($volte--) {
        //mischia l'array in modo random
        shuffle($this->tabella);
        if(COMUNICHE) print_r($this->tabella);
      }
    }while(!$this->risolvibile());
    if(COMUNICHE) echo "</pre>";
    return $this->tabella;
  }
  //-------------------------------------------------------------------------------------------\\
  function visualizza() {
    echo "\n<table bgcolor='yellow' border=1>\n";
    $i=0;
    do{
      echo "  <tr height=50 valign=middle>\n";
      do{
        if((($i+$i/$this->ordine)%2)==0) {
        //if(rand(0,1)) {
          $colore1='red';
          $colore2='orange';
        }
        else {
          $colore1='orange';
          $colore2='red';
        }
        echo "    <td align=center bgcolor='$colore1' width=50><font face='Verdana' color='$colore2' style='font-size: 20pt;'>";
        echo $this->tabella[$i];
        $i++;
        echo "</font></td>\n";
      }while($i%$this->ordine!=0);
      echo "  </tr>\n";
    }while($i/$this->ordine!=$this->ordine);
    echo "</table>\n";
  }
  //-------------------------------------------------------------------------------------------\\
  function muovi_numero($quale,$dove) {
    if($quale<1||$quale>15||count($this->tabella)!=16||$dove<0||$dove>3) {
      return false;
    }
    //ricavo la posizione nel vettore
    $pos=array_search($quale,$this->tabella);
    switch($dove) {
      case su:  //mi devo spostare in SU
          $riga=intval($pos/$this->ordine);
          //sarebbe fuori dal campo?
          if( $riga > 0 && $riga <= $this->ordine) {
            //c'è già un numero in quella posizione?
            if($this->tabella[$pos-$this->ordine]=="") {
              //no, quindi lo sposto
              $this->tabella[$pos-$this->ordine]=$this->tabella[$pos];
              $this->tabella[$pos]="";
            }
            else {
              if(COMUNICHE) echo "<br>in su è occupata da: ".$this->tabella[$pos-$this->ordine]."<br>";
              return false;
            }
          }
          else {
            if(COMUNICHE) echo "numero: $quale nella direzione $dove.... Impossibile spostare!<br>\n";
            return false;
          }
        break;
      case giu: //mi devo spostare in GIU
          $riga=intval($pos/$this->ordine);
          //sarebbe fuori dal campo?
          if( $riga >= 0 && $riga < $this->ordine-1) {
            //c'è già un numero in quella posizione?
            if($this->tabella[$pos+$this->ordine]=="") {
              //no, quindi lo sposto
              $this->tabella[$pos+$this->ordine]=$this->tabella[$pos];
              $this->tabella[$pos]="";
            }
            else {
              if(COMUNICHE) echo "<br>in giu è occupata da: ".$this->tabella[$pos+$this->ordine]."<br>";
              return false;
            }
          }
          else {
            if(COMUNICHE) echo "numero: $quale nella direzione $dove.... Impossibile spostare!<br>\n";
            return false;
          }
        break;
      case dx:  //mi devo spostare a DESTRA
          $colonna=intval($pos%$this->ordine);
          //sarebbe fuori dal campo?
          if( $colonna >= 0 && $colonna < $this->ordine-1) {
            //c'è già un numero in quella posizione?
            if($this->tabella[$pos+1]=="") {
              //no, quindi lo sposto
              $this->tabella[$pos+1]=$this->tabella[$pos];
              $this->tabella[$pos]="";
            }
            else {
              if(COMUNICHE) echo "<br>a destra è occupata da: ".$this->tabella[$pos+1]."<br>";
              return false;
            }
          }
          else {
            if(COMUNICHE) echo "numero: $quale nella direzione $dove.... Impossibile spostare!<br>\n";
            return false;
          }
        break;
      case sx:  //mi devo spostare a SINISTRA
          $colonna=intval($pos%$this->ordine);
          //sarebbe fuori dal campo?
          if( $colonna > 0 && $colonna <= $this->ordine) {
            //c'è già un numero in quella posizione?
            if($this->tabella[$pos-1]=="") {
              //no, quindi lo sposto
              $this->tabella[$pos-1]=$this->tabella[$pos];
              $this->tabella[$pos]="";
            }
            else {
              if(COMUNICHE) echo "<br>a sinistra è occupata da: ".$this->tabella[$pos-1]."<br>";
              return false;
            }
          }
          else {
            if(COMUNICHE) echo "numero: $quale nella direzione $dove.... Impossibile spostare!<br>\n";
            return false;
          }
        break;
    }
  }
  //-------------------------------------------------------------------------------------------\\
  function visualizza_console() {
    echo "
  <script>
    function muovi(dove,numero) {
      //alert(document.getElementById('numero').value);
      num=document.getElementById('numero').value;
      agent.call('','ajax_muovi','ris',dove,num);
    }
    function ris(text) {
      alert(text);
    }
  </script>
  <br><br><input type=text id=numero value=1><br><br>

  <input type=button value=su onClick='muovi(".su.");' style='width:150;'><br>
  <input type=button value=sinistra onClick='muovi(".sx.");' style='width:73;'>
  <input type=button value=destra onClick='muovi(".dx.");' style='width:73;'><br>
  <input type=button value=giu onClick='muovi(".giu.");' style='width:150;'>
  ";
  }
  //-------------------------------------------------------------------------------------------\\
  function finito() {
    $elem2=$this->tabella;
    foreach($elem2 as $elem) {
      $elem--;
    }
    if(count(array_intersect(array_keys($elem2),array_values($elem2))) == count($elem2)) {
      if(COMUNICHE) echo "<br>hai vinto";
      return true;
    }
    else {
      if(COMUNICHE) echo "<br>non hai vinto";
      return false;
    }
  }
  //-------------------------------------------------------------------------------------------\\
  /* ANALISI MATEMATICA DELLA SOLUZIONE
  Una generalizzazione naturale del gioco del quindici è un puzzle di (n * n) - 1 su una griglia n * n.
  Per determinare se a partire da una data configurazione C1 se ne possa raggiungere un'altra C2 occorre
  calcolare le permutazioni dei numeri sulle caselle (nell'$this->ordine di lettura):
  il numero di inversioni (coppie non ordinate),deve essere pari.
  N.B.
  # B contiene tutte le configurazioni che possono portare alla soluzione in un numero finito di mosse.
  # C contiene le configurazioni che non portano a nessuna soluzione.
  * un numero pari di scambi di tasselli porta ad una configurazione appartenente all'insieme di partenza (B o C).
  * un numero dispari di scambi fa passare da C a B (o viceversa).
  Le permutazioni pari di un certo numero (nel nostro caso 15) di oggetti sono esattamente la metà di tutte le permutazioni possibili,
  che sono 15! (15 fattoriale), per un totale di 15x14x13x12x11x10x9x8x7x6x5x4x3 configurazioni possibili.
  ************************************
  Per stabilire se è risolubile è utile
  definire i concetti di inversione e di parità. Se la tessera contenente il numero i compare prima di
  n numeri minori di i allora chiamiamo questa situazione una inversione di $this->ordine n e la chiamiamo ni.
  Osservazione. I numeri vanno letti da destra a sinistra e dall’alto in basso come se fossero in
  una unica striscia. Se definiamo N = i(p) il numero di inversioni della permutazione di numeri che al momento
  compare nel gioco 
  N = sommatoria da i=2 a 15 di ni
  (la sommatoria deve partire da 2 perch´e non ci sono numeri minori di 1) N pu`o essere pari o dispari;
  ² Se N `e pari il gioco `e risolvibile.
  ² Se N `e dispari il gioco non `e risolvibile
  ************************************
  quindi sommo le inversioni
  */
  function risolvibile() {
    $N=0;
    for($i=1;$i<16;$i++) {
      $tmp=array_slice($this->tabella,$i);
      foreach($tmp as $n) {
        if($i>$n) $N++;
      }
    }
    if($N%2 == 0) {
      if(COMUNICHE) echo "<br>è risolvibile<br>";
      return true;
    }
    else {
      if(COMUNICHE) echo "<br>non è risolvibile<br>";
      return false;
    }
  }
  //-------------------------------------------------------------------------------------------\\
  function risolvi() {
    $t=&$this->tabella;
    $pos=array_search("",$t);
    $iteraz=10;
    do{
      $flag=0;
      $dir=rand(0,3);
      switch($dir) {
        case 0: 
          if($pos<=$this->ordine) {
            $flag=1;  
          }
          else {
            if($this->ultimo_numero==$t[$pos-$this->ordine]) {
              $flag=1;
            }
          }
          break;
        case 1: 
          if($pos>=$this->ordine*($this->ordine-1)) {
            $flag=1;
          }
          else {
            if($this->ultimo_numero==$t[$pos+$this->ordine]) {
              $flag=1;
            }
          }
          break;
        case 2: 
          if($pos%$this->ordine==3) {
            $flag=1;
          }
          else {
            if($this->ultimo_numero==$t[$pos+1]) {
              $flag=1;
            }
          }
          break;
        case 3: 
          if($pos%$this->ordine==0) {
            $flag=1;
          }
          else {
            if($this->ultimo_numero==$t[$pos-1]) {
              $flag=1;
            }
          }
          break;
      }
      if(!$flag&&$iteraz>0) {
        if($dir==0 && $pos >= $t[$pos-$this->ordine]&&$iteraz>3) $flag=1;
        if($dir==1 && $pos <= $t[$pos+$this->ordine]&&$iteraz>3) $flag=1;
        if($dir==2 && $pos <= $t[$pos+1]&&$iteraz>3) $flag=1;
        if($dir==3 && $pos >= $t[$pos-1]&&$iteraz>3) $flag=1;
      }
      $iteraz--;
    }while($flag&&$iteraz>=0);
    if(COMUNICHE) echo "posizione ".$pos."<br>direzione ".$dir."<br>ultimo numero spostato: ".$this->ultimo_numero."<br>";
    if($iteraz<0) {
      echo "uscito di forza!<br>";
      return;
    }
    
    switch($dir) {
      case 0:
        $this->ultimo_numero=$t[$pos-$this->ordine];
        $this->muovi_numero($t[$pos-$this->ordine],1);
        break;
      case 1:
        $this->ultimo_numero=$t[$pos+$this->ordine];
        $this->muovi_numero($t[$pos+$this->ordine],0);
        break;
      case 2:
        $this->ultimo_numero=$t[$pos+1];
        $this->muovi_numero($t[$pos+1],3);
        break;
      case 3:
        $this->ultimo_numero=$t[$pos-1];
        $this->muovi_numero($t[$pos-1],2);
        break;
    }
  }
  //-------------------------------------------------------------------------------------------\\
}
//*********************************************  **********************************************\\
//****************************************** TESTING ******************************************\\
//*********************************************  **********************************************\\
session_start();
if(!isset($_SESSION["gioco"]))  $_SESSION["gioco"] = new ilgiocodel15();
$_SESSION["gioco"]->visualizza();
for($i=0;$i<100;$i++) $_SESSION["gioco"]->risolvi();
$_SESSION["gioco"]->visualizza();
//echo "<br><b>RICHIESTA:</b> numero: ".$_GET["numero"]." nella direzione ".$_GET["dove"]."...<br><br>";  muovi_numero($_SESSION["tab"],$_GET["numero"]+0,$_GET["dove"]+0);
?>