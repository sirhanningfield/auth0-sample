<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use App\Email;

class sendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    public $timeout = 3600;
    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Email $email)
    {
        $this->email= $email;
    }

    /**
     * Execute the job.
     * Sending all the emails via sendGrid
     * @return void
     */
    public function handle()
    {
        $email = $this->email;
        $subject = $this->mailSubject($email->paymonth,$email->payyear,$email->payfreq,$email->paydesc);
        $plainbody = $this->mailPlainBody($email->receivername,$email->compname,$email->paymonth,$email->payyear);
        $htmlbody = $this->mailHTMLbody($email->receivername,$email->compname,$email->paymonth,$email->payyear);

        $sendgrid = new \SendGrid\Mail\Mail();
        $sendgrid->setFrom($email->senderemail,$email->sendername);
        $sendgrid->setSubject($subject);
        $sendgrid->addTo($email->receiveremail, $email->receivername);
        $sendgrid->addContent("text/plain",  $plainbody);
        $sendgrid->addContent("text/html", $htmlbody);
        $sendgrid->addAttachment($email->attachment, "application/pdf", $email->receivername.".pdf", "attachment");

        $sendgrid_key = new \SendGrid(getenv('SENDGRID_API_KEY'));

        $sendgrid_response = $sendgrid_key->send($sendgrid);
        $sendgrid_statuscode = $sendgrid_response->statusCode();

        if ($sendgrid_statuscode == 202){
          $email->status = $sendgrid_statuscode;
          $email->save();
        }
        else
        {
          $email->status = $sendgrid_statuscode;
          $email->save();
          throw new Exception ('Failed');
        }
    }

    // Create email subject.
    public function mailSubject($pay_month, $pay_year, $freq, $desc) 
    {
      if ($freq == "Monthly"){
        $subject = "Payslip for pay period " . $pay_month . " " . $pay_year;
      }
      elseif ($freq == "Fortnightly") {
        $subject = "Payslip for pay period " . $pay_month . " " . $desc . " " . $pay_year;
      }
      else{
        $subject = "Payslip for pay period " . $pay_month . " " . $freq . $desc . " " . $pay_year;
      }
      return $subject;
    }

    // Create HTML email body content.
    public function mailHTMLbody($name, $company, $pay_month, $pay_year) 
    {
      $htmlbody = "To ". $name . ",<br><br>" . $company . " has processed your wages for " . $pay_month . " " . $pay_year .
                  ", attached here is your payslip in pdf format.<br>The payslip file is password protected," .
                  " and the password is your birth date in <b>yyyyMmmdd</b> format.<br><br>Regards,<br>" . $company;

      return $htmlbody;
    }

    // Create plain email body content.
    public function mailPlainBody($name, $company, $pay_month, $pay_year) 
    {
      $plainbody = "To ". $name . "," . $company . " has processed your wages for " . $pay_month . " " . $pay_year .
                  ", attached here is your payslip in pdf format.The payslip file is password protected," .
                  " and the password is your birth date in yyyyMmmdd format.Regards," . $company;

      return $plainbody;
    }
}
