<?php 

namespace App\Controller;

use App\Entity\Picture;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', 'home.index', methods:['GET'])]
    public function index()
    {
        return $this->render('home.html.twig');
    }

    #[Route('/import', 'home.import', methods:['GET'])]
    public function import(EntityManagerInterface $entityManager,
    #[Autowire('%kernel.project_dir%/public/imgs/')] string $directory)
    {

        $data = json_decode(file_get_contents("data.json"), true);


        foreach($data["years"] as $years => $days){
            //echo "<pre>"; print_r($days);echo "</pre>"; 
            foreach($days as $day => $content){
                preg_match("#([0-9]{4})([0-9]{2})([0-9]{2})#", $day, $date);
                $date = new DateTime($date[1]."/".$date[2]."/".$date[3]);
                foreach($content["pictures"] as $image){

                    //echo "<pre>"; print_r($image); echo "</pre>";
                   
                    preg_match("#pictures\/[0-9]{4}\/[0-9]{8}\/(.*)#", $image["src"], $matchs);
                    $filename = $matchs[1];
                    $from = "img/".$image["src"];
                    $to = $directory . $filename;
                    copy($from, $to);

                    $picture = new Picture;
                    $picture->setFilename($filename);
                    $picture->setAlt($image["alt"]);
                    $picture->setDate($date);

                    echo "<pre>"; print_r($picture); echo "</pre>";
                   
                    // $entityManager->persist($picture);
                    // $entityManager->flush();
                }
                
            }
           
        }

        return $this->render('import.html.twig');
    }
}

?>