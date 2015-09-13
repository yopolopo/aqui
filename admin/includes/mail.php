<?php
class lib_mail
{
	private $sender = null;
	private $to = array();
	private $cc = array();
	private $bcc = array();
	private $subject = null;
	
	private $text = null;
	private $html = null;
	
	public function addTo($mail, $name = null)
	{
		if ($name === null)
		{
			$this->to[] = $mail;
		}
		else
		{
			$this->to[] = array('name' => $name, 'mail' => $mail);
		}
	}
	
	public function addCc($mail, $name = null)
	{
		if ($name === null)
		{
			$this->cc[] = $mail;
		}
		else
		{
			$this->cc[] = array('name' => $name, 'mail' => $mail);
		}
	}
	
	public function addBcc($mail, $name = null)
	{
		if ($name === null)
		{
			$this->bcc[] = $mail;
		}
		else
		{
			$this->bcc[] = array('name' => $name, 'mail' => $mail);
		}
	}
	
	public function subject($subject = null)
	{
		if ($subject !== null)
		{
			$this->subject = $subject;
		}
		return $this->subject;
	}
	
	public function sender($mail, $name = null)
	{
		if ($name === null)
		{
			$this->sender = $mail;
		}
		else
		{
			$this->sender = array('name' => $name, 'mail' => $mail);
		}
	}
	
	public function text($text, $append = false)
	{
		if ($append === false || $this->text === null)
		{
			$this->text = $text;
		}
		else
		{
			$this->text .= $text;
		}
	}
	
	public function html($html, $append = false)
	{
		if ($append === false || $this->html === null)
		{
			$this->html = $html;
		}
		else
		{
			$this->html .= $html;
		}
	}
	
	public function send()
	{
		$headers = '';
		$body = '';

		$cto = count($this->to);
		$ccc = count($this->cc);
		$cbcc = count($this->bcc);
		
		if ($cto < 1 && $ccc < 1 && $cbcc < 1)
		{
			throw new Exception('Trying to send an e-mail without recipients');
		}
		
		if ($this->text === null && $this->html === null)
		{
			throw new Exception('Trying to send an e-mail without body');
		}
		else if ($this->text !== null && $this->html === null)
		{
			$body = $this->text;
		}
		else if ($this->text === null && $this->html !== null)
		{
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$body = $this->html;
		}
		else
		{
			$boundary = md5(microtime(true));
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-Type: multipart/alternative; boundary="' . $boundary . '"' . "\r\n";
			$headers .= 'Content-Transfer-Encoding: 7bit' . "\r\n";
			
			$body .= '--' . $boundary . "\n";
			$body .= 'Content-Type: text/plain; charset=utf-8' . "\n";
			$body .= 'Content-Transfer-Encoding: 7bit' . "\n\n";
			$body .= $this->text;
			$body .= "\n\n";
			
			$body .= '--' . $boundary . "\n";
			$body .= 'Content-Type: text/html; charset=utf-8' . "\n";
			$body .= 'Content-Transfer-Encoding: 7bit' . "\n\n";
			$body .= $this->html;
			$body .= "\n\n";
			
			$body .= '--' . $boundary . "\n";
		}

		$to = array();
		$cc = array();
		$bcc = array();

		if ($cto > 0)
		{
			foreach ($this->to as $user)
			{
				if (is_array($user))
				{
					$to[] = $user['name'] . '<'.$user['mail'].'>';
				}
				else
				{
					$to[] = $user;
				}
			}
			$to = implode(',', $to);
		}
		
		
		if ($ccc > 0)
		{
			foreach ($this->cc as $user)
			{
				if (is_array($user))
				{
					$cc[] = $user['name'] . '<'.$user['mail'].'>';
				}
				else
				{
					$cc[] = $user;
				}
			}
			$cc = implode(',', $cc);
			$headers .= 'CC: ' . $cc . "\r\n";
		}
		
		if ($cbcc > 0)
		{
			foreach ($this->bcc as $user)
			{
				if (is_array($user))
				{
					$bcc[] = $user['name'] . '<'.$user['mail'].'>';
				}
				else
				{
					$bcc[] = $user;
				}
			}
			$bcc = implode(',', $bcc);
			$headers .= 'Bcc: ' . $bcc . "\r\n";
		}

		if ($this->sender !== null)
		{
			if (is_array($this->sender))
			{
				$headers .= 'From: '.$this->sender['name'].' <'.$this->sender['mail'].'>'."\r\n";
			}
			else
			{
				$headers .= 'From: '.$this->sender."\r\n";
			}
		}

		if ($this->subject !== null)
		{
			$subject = $this->subject;
		}
		
		return mail($to, $subject, $body, $headers);
	}
}
