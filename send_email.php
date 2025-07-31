<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Получаем данные из формы
  $name = strip_tags(trim($_POST["name"]));
  $name = str_replace(array("\r", "\n"), array(" ", " "), $name);
  $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
  $message = trim($_POST["message"]);

  // Проверяем данные
  if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Если что-то не так, возвращаем ошибку
    http_response_code(400);
    echo "Пожалуйста, заполните все поля и укажите корректный email.";
    exit;
  }

  // Устанавливаем получателя письма
  $recipient = "cheatcheatov084@gmail.com";

  // Формируем тему письма
  $subject = "Сообщение с сайта от $name";

  // Формируем текст письма
  $email_content = "Имя: $name\n";
  $email_content .= "Email: $email\n\n";
  $email_content .= "Сообщение:\n$message\n";

  // Формируем заголовки письма
  $email_headers = "From: $name <$email>\r\n";
  $email_headers .= "Reply-To: $email\r\n";

  // Отправляем письмо
  if (mail($recipient, $subject, $email_content, $email_headers)) {
    // Если письмо отправлено успешно
    http_response_code(200);
    echo "Спасибо! Ваше сообщение отправлено.";
  } else {
    // Если произошла ошибка при отправке
    http_response_code(500);
    echo "К сожалению, произошла ошибка при отправке сообщения. Пожалуйста, попробуйте позже.";
  }

} else {
  // Если страница загружена не через POST-запрос
  http_response_code(403);
  echo "Произошла ошибка. Пожалуйста, попробуйте отправить форму еще раз.";
}
?>
