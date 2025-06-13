<?php
namespace App\Controllers;


use App\Utils\Flash;
use App\Utils\View;
use App\Repositories\PerfilRepository;
use App\Models\Perfil;
use App\Services\ImageUploader;


class PerfilController{
    private $perfilRepository;

    public function __construct(){
        if(!isset($_SESSION['user'])){
            header('Location:'. BASE_URL.  '/login');
            exit;
        }
        $this->perfilRepository = new PerfilRepository();
    }

    public function index(){
        $userId = $_SESSION['user']['id'];

        $perfil = $this->perfilRepository->findByUserId($userId);

        if(!$perfil)
        {
            Flash::set('message', 'Perfil nao encotrado ');
            header('Location:'. BASE_URL.  '/perfil/create');
            exit;
        }
        
            $content = (new View())->render('perfil/index', [
            ]);
            return $content;
        
    
    }

    

    /**
     * Atualiza as informações do perfil.
     */
    public function update($request)
    {
        $userId = $_SESSION['user']['id']; // Pega o ID do usuário da sessão

        $perfil = $this->perfilRepository->findByUserId($userId);
        if (!$perfil) {
            Flash::set('message', 'Perfil não encontrado.');
            header('Location: ' . BASE_URL . '/perfil');
            exit;
        }

        $data = $request->getBody();

        $perfil->setNome($data['nome']);
        $perfil->setSobrenome($data['sobrenome']);
        $perfil->setBio($data['bio']);
        $perfil->setGithub($data['github']);
        $perfil->setLinkedin($data['linkedin']);

        $newPhotoPath = ImageUploader::upload($data, $_FILES, 'perfis', $perfil->getFoto());
        if ($newPhotoPath) {
            $perfil->setFoto($newPhotoPath);
        }
        
        $this->perfilRepository->save($perfil);

        Flash::set('message', 'Perfil atualizado com sucesso!');
        header('Location: ' . BASE_URL . '/perfil');
        exit;
    }
}