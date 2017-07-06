<?php

namespace Hcode;

use Rain\Tpl;

class Mailer {

	const USERNAME = "oliveirauelder318@gmail.com";
	const PASSWORD = "wu0106xyz2";
	const NAME_FROM = "Hcode Store";

	private $mail;

	public function __construct($toAddress, $toName, $subject, $tplName, $data = array())
	{

		$config = array(
			"tpl_dir"   =>$_SERVER["DOCUMENT_ROOT"]."/views/email",
			"cache_dir" =>$_SERVER["DOCUMENT_ROOT"]."/views-cache/",
			"debug"     => false

			);

			Tpl::configure($config);

			$tpl = new Tpl;

			foreach ($data as $key => $value) {
				$tpl->assign($key, $value);

			}

			$html = $tpl->draw($tplName, true);

			$this->mail = new \PHPMailer;

		// Crie uma nova instância do PHPMailer
		$this->mail = new \PHPMailer;

		// Diga ao PHPMailer que use SMTP
		$this->mail->isSMTP ();

		// Habilitar depuração de SMTP
		// 0 = desligado (para uso em produção)
		// 1 = mensagens do cliente
		// 2 = mensagens do cliente e do servidor
		$this->mail->SMTPDebug = 0;

		// Pedir saída de depuração compatível com HTML
		$this->mail->Debugoutput  =  ' html ' ; 

		// Definir o nome do host do servidor de correio
		$this->mail->host  =  ' smtp.gmail.com ';

		// use
		// $ mail-> Host = gethostbyname ('smtp.gmail.com');
		// se sua rede não suportar SMTP sobre IPv6
		// Defina o número da porta SMTP - 587 para TLS autenticado, também conhecido como submissão RFC4409 SMTP
		$this->mail->Port = 587;

		// Defina o sistema de criptografia para usar - ssl (obsoleto) ou tls
		$this->mail->SMTPSecure = 'tls';

		// Se usar a autenticação SMTP
		$this->mail->SMTPAuth  =  true ;

		// Nome de usuário para usar para autenticação SMTP - use o endereço de e-mail completo para o gmail
		$this->mail->Username = Mailer::USERNAME;

		// Senha para usar para autenticação SMTP
		$this->mail->Password = Mailer::PASSWORD;

		// Definir de quem a mensagem deve ser enviada
		$this->mail->setFrom (Mailer::USERNAME, Mailer::NAME_FROM);

		// Definir uma resposta alternativa ao endereço
		//$this->mail->addReplyTo ( ' replyto@example.com ' , ' First Last ' );
		// Defina quem a mensagem deve ser enviada para
		$this->mail->addAddress ($toAddress, $toName);

		// Defina a linha de assunto
		$this->mail->Subject = $subject;

		// Ler um corpo de mensagem HTML de um arquivo externo, converter imagens referenciadas para incorporadas,
		// converte HTML em um corpo alternativo básico de texto simples
		$this->mail->msgHTML($html);

		// Substitua o corpo de texto simples por um criado manualmente
		$this->mail->AltBody  =  "Teste Uelder";

		// Anexe um arquivo de imagem
		//$this->mail -> addAttachment ( ' images / phpmailer_mini.png ' );
    }

	public function send()
	{

		return $this->mail->send();

	}
}

?>