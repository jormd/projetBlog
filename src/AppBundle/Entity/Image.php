<?php
/**
 * Created by PhpStorm.
 * User: romandjohann
 * Date: 14/12/2017
 * Time: 11:40
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity
 * Class Image
 * @package AppBundle\Entity
 * @Vich\Uploadable
 */
class Image
{

    protected static $path = 'img/';

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName", size="imageSize")
     *
     * @var UploadedFile
     */
    protected $file;

    /**
     * @ORM\Column(type="string")
     */
    protected $imageName;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @param mixed $nameComplet
     */
    public function setImageName($nameComplet)
    {
        $this->imageName = $nameComplet;
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param File $file
     */
    public function setFile(File $file)
    {
        $this->file = $file;
    }

    public function getPathFichier(){
        return self::$path.$this->getImageName();
    }

}