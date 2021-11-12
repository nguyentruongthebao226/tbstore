<?php

require '' . LIBRARY_VENDOR_PATH . 'autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail extends Controller
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->SMTPDebug = 0;
        $this->mail->isSMTP();
        $this->mail->Host       = 'smtp.gmail.com';
        $this->mail->SMTPAuth   = true;
        $dataPath               = TEMPLATE_PATH . 'admin/main/data/';
        $data = file_get_contents($dataPath . 'mail-admin.json');
        $data = json_decode($data, TRUE);
        $this->mail->Username   = $data['EmailConfig'];
        $this->mail->Password   = $data['EmailPassword'];
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port       = 587;
        $this->mail->CharSet = 'UTF-8';
    }

    public function sendMail($source, $option = null)
    {
        $result = true;
        if ($option['task'] == 'send-mail-to-admin') {
            $this->mail->setFrom($_POST['form']['email'], $_POST['form']['name']);
            $this->mail->addAddress('callmebaobao22@gmail.com');
            // $this->mail->addCC('abc@gmail.com');
            $this->mail->Subject = $source['subject'];
            $this->mail->Body    = 'Người gửi:  ' . $source['email'] . ' ---- Nội dung: ' . $source['description'] . ' ';
            $this->mail->send();
        }

        if ($option['task'] == 'send-mail-to-user') {
            $this->mail->setFrom('callmebaobao22@gmail.com', 'TB Store');
            $this->mail->addAddress($source['email']);
            $this->mail->Subject = 'Thông báo từ TB Store';
            $this->mail->Body    = 'Xin chào ' . $source['name'] . ', TB Store đã nhận được lời nhắn của bạn. Cảm ơn quý khách đã liên hệ và góp ý đến chúng tôi, TB Store sẽ phản hồi chậm nhất 3 ngày tính từ ngày quý khách hàng gửi mail!';
            $this->mail->send();
        }
    }
}
