<?php


class Usuario{
    public $nome;
    public $email;
    private $senha;
    public $telefone;
    public $listaLivros = [];

    const MAX_EMPRESTIMO = 3;

    public function __construct($usuario){
        $this->nome = $usuario['nome'];
        $this->email = $usuario['email'];
        $this->senha = $usuario['senha'];
        $this->telefone = $usuario['telefone'];
    }

    public function pegarEmprestado($livro){
        if(count($this->listaLivros) >= self::MAX_EMPRESTIMO){
            return;
        }
        array_push($this->listaLivros, $livro);
    }

    public function devolverEmprestimo($livro){
        if(count($this->listaLivros) == 0){
            echo "Não há livros para devolver";
            return;
        }
        $key = array_search($livro, $this->listaLivros);
        if($key !== false){
            unset($this->listaLivros[$key]);
        }
    }
}


class Livro{
    public $titulo;
    public $autor;
    public $genero;
    public $isbn;
    public $usuarioEmprestado;
    public $status = 'Disponível'; 

    public function __construct($livro){
        $this->titulo = $livro['titulo'];
        $this->autor = $livro['autor'];
        $this->genero = $livro['genero'];
        $this->isbn = $livro['isbn'];
    }

    public function emprestarLivro($usuario){
        if($this->status == 'Indisponivel'){
            echo 'Livro já está emprestado';
            return;
        }
        $this->usuarioEmprestado = $usuario;
        $this->status = 'Indisponivel';
    }

    public function devolverLivro($usuario){
        if($this->status == 'Disponível'){
            echo 'Livro não está emprestado';
            return;
        }
        $this->usuarioEmprestado = null;
        $this->status = 'Disponível';
    }
}

class Biblioteca{
    public static function Emprestar($livro, $usuario){
        $livro->emprestarLivro($usuario);
        $usuario->pegarEmprestado($livro);
    }

    public static function Devolver($livro, $usuario){
        $livro->devolverLivro($usuario);
        $usuario->devolverEmprestimo($livro);
    }
}

/*-----------------------------------------*/


$caique = new Usuario(
    [
        'nome' => 'Caique Fernandes',
        'email' => 'caique@email.com',
        'senha' => '123654',
        'telefone' => '67999999-9999'
    ]
);

echo '<hr>';

$domCasmurro = new Livro(
    [
        'titulo' => 'Dom Casmurro',
        'autor' => 'Machado de Assis',
        'genero' => 'romance',
        'isbn' => '123123456'
    ]
);
var_dump($domCasmurro);

echo '<hr>';

$caique->pegarEmprestado($domCasmurro);
$caique->devolverEmprestimo($domCasmurro);
var_dump($caique->listaLivros);
var_dump($caique);
