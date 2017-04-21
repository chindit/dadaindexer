<?php
declare(strict_types=1);

namespace Dada\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * File
 *
 * @ORM\Entity
 * @ORM\Table(name="file")
 * @ORM\Entity(repositoryClass="Dada\Repository\FileRepository")
 */
class File
{
    const PICTURE = 'picture';
    const VIDEO = 'video';
    const EBOOK = 'ebook';
    const OTHER = 'other';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="mime", type="string", length=50)
     */
    private $mime;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Directory")
     */
    private $directory;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbnail", type="string", length=50, nullable=true, unique=true)
     */
    private $thumbnail;

    /**
     * @var int
     *
     * @ORM\Column(name="width", type="integer", nullable=true)
     */
    private $width;

    /**
     * @var int
     *
     * @ORM\Column(name="height", type="integer", nullable=true)
     */
    private $height;

    /**
     * @var int
     *
     * @ORM\Column(name="weight", type="bigint", nullable=false)
     */
    private $weight;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetime", nullable=true)
     */
    private $modified;

    /**
     * @var string
     *
     * @ORM\Column(name="md5sum", type="string", length=32, nullable=true, unique=true)
     */
    private $md5sum;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=500, nullable=true)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=25)
     */
    private $type;

    public function __construct()
    {
        $this->width = 0;
        $this->height = 0;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $name
     *
     * @return File
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set mime
     *
     * @param string $mime
     *
     * @return File
     */
    public function setMime($mime)
    {
        $this->mime = $mime;

        return $this;
    }

    /**
     * Get mime
     *
     * @return string
     */
    public function getMime()
    {
        return $this->mime;
    }

    /**
     * Set parent
     *
     * @param Directory|null $directory
     *
     * @return File
     */
    public function setDirectory(Directory $directory = null) : File
    {
        $this->directory = $directory;

        return $this;
    }

    /**
     * Get parent
     *
     * @return int
     */
    public function getDirectory() : ?Directory
    {
        return $this->directory;
    }

    /**
     * Set thumbnail
     *
     * @param string $thumbnail
     *
     * @return File
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * Set width
     *
     * @param integer $width
     *
     * @return File
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param integer $height
     *
     * @return File
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     * @return File
     */
    public function setWeight(int $weight): File
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     *
     * @return File
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Set md5sum
     *
     * @param string $md5sum
     *
     * @return File
     */
    public function setMd5sum($md5sum)
    {
        $this->md5sum = $md5sum;

        return $this;
    }

    /**
     * Get md5sum
     *
     * @return string
     */
    public function getMd5sum()
    {
        return $this->md5sum;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     * @return File
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return File
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}

