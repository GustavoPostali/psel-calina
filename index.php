<?php

//variáveis que armazenam a mensagem de feedback/erro e a classe para aplicação do estilo da mensagem
$feedback_message = '';
$message_class = '';

//checa se a requisição post foi realizada
if (filter_has_var(INPUT_POST, 'submit')) {

    //tratamento e armazenamento dos valores recebidos pela requisição post
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    if (isset($_POST['options'])) {
        $option = $_POST['options'];
    }


    //validação e atribuição das mensagens de feedback de acordo com os valores das variáveis
    if (empty($name) or empty($phone) or empty($email)) {
        $feedback_message = 'Por favor preencha todos os campos!';
        $message_class = 'alert-danger';
    } else {
        if (empty($option)) {
            $feedback_message = 'Por favor selecione uma opção!';
            $message_class = 'alert-danger';
        } else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $feedback_message = 'Email Inválido!';
            $message_class = 'alert-danger';
        } else { //em caso de sucesso da validação das variáveis envia o email e atribui mensagem de sucesso para feedback
            $to = "leandro@calina.ag";
            $subject = "LEAD LANDING PAGE PROCESSO SELETIVO CALINA";
            $mail_message = "Nome: " . $name . "\nTelefone: " . $phone . "\nEmail: " . $email . "\nOpção: " . $option;

            mail($to, $subject, $mail_message);
            $feedback_message = 'Obrigado!';
            $message_class = 'alert-success';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Landing Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="style/style.css" />
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/f6e88e4034.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/imask/5.2.1/imask.js" integrity="sha256-jyvNMeTcc9J0dbND46mIzyfWy0Nm77VtxySPIYuj+Xg=" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container-fluid text-center">
        <div id="banner">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="welcome-block">
                        <div id="welcome-header">
                            <h1>Bem-Vindo!</h1>
                            <br />
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                Ipsam atque quia recusandae non fugit officia delectus id
                                corporis, sequi est repellat molestias aut, itaque deserunt
                                quam? Quibusdam magnam fugiat ipsam.
                            </p>
                            <a href="#info" class="btn btn-primary">Mais Informações<i class="fas fa-info-circle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-block">
                        <div class="form-container">
                            <h1>Deixe Seu Contato!</h1>
                            <br />
                            <?php
                            if ($feedback_message != '') {
                                echo "<div class='alert " . $message_class . "' role='alert'>" . $feedback_message . "</div>";
                            }
                            ?>
                            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input pattern="^[a-zA-Z ]*$" class="form-control" id="name" aria-describedby="name" placeholder="Nome" name="name" oninvalid="setCustomValidity('Nomes só podem conter letras!')" oninput="setCustomValidity('')" value="<?php echo isset($_POST['name']) ? $name : ''; ?>" />
                                </div>
                                <div class="form-group">
                                    <label for="phone">Telefone (Com DDD)</label>
                                    <input pattern="\(\d{2}\)\d{4,5}-\d{4}$" class="form-control" id="phone" aria-describedby="phone" placeholder="Telefone" name="phone" oninvalid="setCustomValidity('Número de telefone inválido!')" oninput="setCustomValidity('')" value="<?php echo isset($_POST['phone']) ? $phone : ''; ?>" />
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" aria-describedby="email" placeholder="Email" name="email" value="<?php echo isset($_POST['email']) ? $email : ''; ?>" />
                                </div>
                                <div class="form-group">
                                    <label for="options">Selecione uma opção</label>
                                    <select class="form-control" id="options" name="options">
                                        <option value='0'></option>
                                        <option value='1'>Opção 1</option>
                                        <option value='2'>Opção 2</option>
                                        <option value='3'>Opção 3</option>
                                        <option value='4'>Opção 4</option>
                                        <option value='5'>Opção 5</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success" name='submit'>Enviar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="padding">
        <div class="container-fluid text-center">
            <div id="info">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="info-block">
                            <div class="info-text">
                                <h1>INFO</h1>
                                <br />
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    Ipsam atque quia recusandae non fugit officia delectus id
                                    corporis, sequi est repellat molestias aut, itaque deserunt
                                    quam? Quibusdam magnam fugiat ipsam.
                                </p>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    Ipsam atque quia recusandae non fugit officia delectus id
                                    corporis, sequi est repellat molestias aut, itaque deserunt
                                    quam? Quibusdam magnam fugiat ipsam.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="info-block">
                            <div class="info-text">
                                <h1>INFO</h1>
                                <br />
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    Ipsam atque quia recusandae non fugit officia delectus id
                                    corporis, sequi est repellat molestias aut, itaque deserunt
                                    quam? Quibusdam magnam fugiat ipsam.
                                </p>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    Ipsam atque quia recusandae non fugit officia delectus id
                                    corporis, sequi est repellat molestias aut, itaque deserunt
                                    quam? Quibusdam magnam fugiat ipsam.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="padding">
            <div class="container-fluid text-center">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="contact-block">
                            <div class="contact-text">
                                <h3>Entre em Contato</h3>
                                <br />
                                <p>Informarções sobre o produto/serviço</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="social-block">
                            <div class="social-text">
                                <h3>Redes Sociais</h3>
                                <br />
                                <a href="#" class="fab fa-facebook-f"></a>
                                <a href="#" class="fab fa-instagram"></a>
                                <a href="#" class="fab fa-youtube"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        $(document).ready(function() {
            IMask($("#phone")[0], {
                mask: [{
                        mask: "(00)0000-0000"
                    },
                    {
                        mask: "(00)00000-0000"
                    }
                ]
            });
        });
    </script>
</body>

</html>