<?php

namespace Blog;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlogCategory
 *
 * @ORM\Table(name="blog_category", indexes={@ORM\Index(name="blog_id", columns={"blog_id"}), @ORM\Index(name="category_id", columns={"category_id"})})
 * @ORM\Entity
 */
class BlogCategory
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
     * @var \Blog
     *
     * @ORM\ManyToOne(targetEntity="Blog")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="blog_id", referencedColumnName="id")
     * })
     */
    private $blog;

    /**
     * @var \Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;



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
     * Set blog.
     *
     * @param \Blog|null $blog
     *
     * @return BlogCategory
     */
    public function setBlog(\Blog $blog = null)
    {
        $this->blog = $blog;

        return $this;
    }

    /**
     * Get blog.
     *
     * @return \Blog|null
     */
    public function getBlog()
    {
        return $this->blog;
    }

    /**
     * Set category.
     *
     * @param \Category|null $category
     *
     * @return BlogCategory
     */
    public function setCategory(\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category.
     *
     * @return \Category|null
     */
    public function getCategory()
    {
        return $this->category;
    }
}
