<?php

namespace App\Entity;

use App\Repository\BlogPostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Author;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: BlogPostRepository::class)]
#[UniqueEntity(fields: ['title', 'slug'], message: 'There is already a post with that title/slug.')]

class BlogPost
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private $id;
    #[ORM\Column(type: 'string', length:255)]
    private $slug;
    #[ORM\Column(type: 'string', length:255)]
    private $title;
    #[ORM\Column(type: 'text')]
    private $description;
    #[ORM\Column(type: 'text')]
    private $body;
    #[ORM\Column(type: 'text')]
    private $imageURL;
    #[ORM\Column(type: 'string', length:255)]
    private $category;
    #[ORM\Column(type: 'date')]
    private $createdAt;
    #[ORM\Column(type: 'date')]
    private $updatedAt;

    #[ORM\ManyToOne(targetEntity: Author::class, inversedBy: 'blogPosts')]
    private $author;

    #[ORM\ManyToMany(targetEntity: self::class)]
    #[ORM\JoinTable(name:'relatedPosts', joinColumns:['blogPost_a_id', 'id'], inverseJoinColumns:['blogPost_b_id', 'id'])]
    private $relatedPosts;

    public function __construct()
    {
        $this->relatedPosts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getSlug()
    {
        return $this->slug;
    }
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    public function getImageURL()
    {
        return $this->imageURL;
    }
    public function setImageURL($imageURL)
    {

        $this->imageURL = $imageURL;
        
        return $this;
    }

    public function getCategory()
    {
        return $this->category; 
    }
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    } 
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
    */
    public function updatedTimestamps(): void
    {
        $this->setUpdatedAt(new \DateTime('now'));    
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getRelatedPosts(): Collection
    {
        return $this->relatedPosts;
    }

    public function addRelatedPost(self $relatedPost): self
    {
        if (!$this->relatedPosts->contains($relatedPost)) {
            $this->relatedPosts[] = $relatedPost;
        }

        return $this;
    }

    public function removeRelatedPost(self $relatedPost): self
    {
        $this->relatedPosts->removeElement($relatedPost);

        return $this;
    }

}