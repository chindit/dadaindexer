<?php
declare(strict_types=1);

namespace Dada\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Directory
 *
 * @ORM\Entity
 * @ORM\Table(name="directory")
 * @ORM\Entity(repositoryClass="Dada\Repository\DirectoryRepository")
 */
class Directory
{
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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var int
     *
     * @ORM\Column(name="level", type="integer")
     */
    private $level;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Directory")
     */
    private $parent;


    /**
     * Constructor
     * @param \DirectoryIterator $directoryIterator
     * @param int $level
     * @param Directory|null $parent
     */
    public function __construct(\DirectoryIterator $directoryIterator, int $level = 0, Directory $parent = null)
    {
        $this->name = $directoryIterator->getFilename();
        $this->path = $directoryIterator->getBasename();
        $this->parent = $parent;
        $this->level = $level;
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
     * @return Directory
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
     * Set chemin
     *
     * @param string $path
     *
     * @return Directory
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get chemin
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set niveau
     *
     * @param integer $level
     *
     * @return Directory
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set parent
     *
     * @param Directory $parent
     *
     * @return Directory
     */
    public function setParent(Directory $parent) : Directory
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return Directory
     */
    public function getParent() : Directory
    {
        return $this->parent;
    }
}
