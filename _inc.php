<?php
include(__DIR__.'/SimpleMailReporter.php');
include(__DIR__.'/SimpleMailSanitizer.php');
include(__DIR__.'/SimpleMailConfig.php');
include(__DIR__.'/SimpleMailMailer.php');
include(__DIR__.'/SimpleMailForm.php');
include(__DIR__.'/SimpleMailWidget.php');
include(__DIR__ . '/SimpleMailProcessor.php');
include(__DIR__.'/SimpleMailClass.php');

global $sm;
$sm = new SimpleMail();