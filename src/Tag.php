<?php

namespace Blog;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tag
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity
 */
class Tag
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;


//    /**
//     * @ORM\ManyToMany(targetEntity=Blog::class)
//     * @ORM\JoinTable(
//     *  name="blog_tag",
//     *  joinColumns={
//     *      @ORM\JoinColumn(name="blog_id", referencedColumnName="id")
//     *  },
//     *  inverseJoinColumns={
//     *      @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
//     *  }
//     *  )
//     */
//    private $blogs;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Tag
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

//    public function addBlog(Blog $blog)
//    {
//        $this->blogs->add($blog);
//    }
//
//    public function removeBlog(Blog $blog)
//    {
//        $this->blogs->removeElement($blog);
//    }
}
