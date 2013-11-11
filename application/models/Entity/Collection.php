<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Collection
 */
class Collection
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $secret;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $sharedFiles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sharedFiles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Collection
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set secret
     *
     * @param string $secret
     * @return Collection
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;

        return $this;
    }

    /**
     * Get secret
     *
     * @return string 
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add sharedFiles
     *
     * @param \Entity\Sharing $sharedFiles
     * @return Collection
     */
    public function addSharedFile(\Entity\Sharing $sharedFiles)
    {
        $this->sharedFiles[] = $sharedFiles;

        return $this;
    }

    /**
     * Remove sharedFiles
     *
     * @param \Entity\Sharing $sharedFiles
     */
    public function removeSharedFile(\Entity\Sharing $sharedFiles)
    {
        $this->sharedFiles->removeElement($sharedFiles);
    }

    /**
     * Get sharedFiles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSharedFiles()
    {
        return $this->sharedFiles;
    }
}
