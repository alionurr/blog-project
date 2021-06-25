<?php

namespace Blog;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlogTag
 *
 * @ORM\Table(name="blog_tag", indexes={@ORM\Index(name="b2t_blog", columns={"blog_id"}), @ORM\Index(name="b2t_tag", columns={"tag_id"})})
 * @ORM\Entity
 */
class BlogTag
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
     * @var \Tag
     *
     * @ORM\ManyToOne(targetEntity="Tag")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     * })
     */
    private $tag;



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
     * @return BlogTag
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
     * Set tag.
     *
     * @param \Tag|null $tag
     *
     * @return BlogTag
     */
    public function setTag(\Tag $tag = null)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag.
     *
     * @return \Tag|null
     */
    public function getTag()
    {
        return $this->tag;
    }
}
