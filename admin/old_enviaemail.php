<?php

require_once('class.phpmailer.php');
require_once('class.smtp.php');

/**
* 
*/
class EnviaEmail 
{
  
  function enviar($arguntos) {
     
    # code...
    $mail = new phpmailer(true); // the true param means it will throw exceptions on errors, which we need to catch
    $mail->IsSMTP(); // telling the class to use SMTP
    $mail->Host       = Host; // SMTP server
    $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
    $mail->IsHTML(true);    
    
    $mail->SMTPAuth   = SMTPAuth;                  // enable SMTP authentication
    $mail->SMTPSecure = SMTPSecure;                 // sets the prefix to the servier
    $mail->Port       = Port;                   // set the SMTP port for the GMAIL server
    $mail->Username   = Username;  // GMAIL username
    $mail->Password   = Password;            // GMAIL password
      $mail->AddAddress($arguntos['email'], $arguntos['nomebusca']);
    
    if(AddReplyTo != '')
      $mail->AddReplyTo(AddReplyTo);
    $mail->Subject = $arguntos['Subject'];
    $mail->From = SetFromEmail;
    $mail->FromName = SetFromNome;
    $mail->Body = $arguntos['conteudo']; // optional - MsgHTML will create an alternate automatically
    // $mail->MsgHTML($arguntos['conteudo']);
    if ($mail->Send()) 
      echo "<p>Mensagem enviada com Sucesso!!!!</p>\n";
  }
  function emailAcompanhamento($email){
    $email['conteudo'] = "<html><head></head><body>";
    $email['conteudo'] .= '<img src="http://www.sicoobcrediembrapa.com.br/images/imgs/cabecalho.jpg"><br>';
    $email['conteudo'] .= "Prezado(a) Associado(a), <br><br>";
    $email['conteudo'] .= "Sua solicitação nº: <b>".$email['os']."</b> está em andamento. Seguem informações para conhecimento:<br><br><b><i>\"".$email['descompmensagem']."\"</b></i>";
    $email['conteudo'] .= '<br><img src="http://www.sicoobcrediembrapa.com.br/images/imgs/rodape.jpg">';
    $email['conteudo'] .= "</body></html>";


    $email['Subject'] = 'SICOOB - Andamento de OS';
    $this->enviar($email);
  }
  function emailAbertura($email){
    $email['conteudo'] = "<html><head></head><body>";
    $email['conteudo'] .= '<img src="http://www.sicoobcrediembrapa.com.br/images/imgs/cabecalho.jpg">';
    $email['conteudo'] .= "<br><br>Prezado(a) Associado(a), <br>
Sua solicitação foi registrada através da OS: <b>".$email['os']."</b><br><br>";
    $email['conteudo'] .= "Agradecemos o seu contato e permanecemos à disposição.<br><br>";
    $email['conteudo'] .= "Sicoob";
    $email['conteudo'] .= '<br><img src="http://www.sicoobcrediembrapa.com.br/images/imgs/rodape.jpg"><br>';
    $email['conteudo'] .= "</body></html>";
    $email['Subject'] = 'SICOOB - Abertura de OS';
    $this->enviar($email);
  }
  function emailAvaliacao($email){
    $email['conteudo'] = "<html><head></head><body>";
    $email['conteudo'] .= '<img src="http://www.sicoobcrediembrapa.com.br/images/imgs/cabecalho.jpg"><br>';
    $email['conteudo'] .= "<br><br>Prezado(a) associado(a), <br><br>
Sua solicitação da <b>OS ".$email['os']."</b> foi encerrada com sucesso.<br><br>";
    $email['conteudo'] .= 'Gostaríamos de saber sua opini&atilde;o sobre o nosso atendimento<br><br> Segue o link para avaliação do atendimento: <a href="'.$email['link'].'">Clique aqui para acessar.</a>';
    $email['conteudo'] .= '<br><img src="http://www.sicoobcrediembrapa.com.br/images/imgs/rodape.jpg"><br>';
    $email['conteudo'] .= "</body></html>";
    $email['Subject'] = 'SICOOB - OS Concluída';
    $this->enviar($email);
  }
}
