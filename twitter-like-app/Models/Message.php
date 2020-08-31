<?php
/**
 * This class represents a Message model
 */
class Message
{
    private $username;
    private $content;
    private $created_at;

    public function __construct(array $data = [])
    {
        $this->setUsername($data['username']);
        $this->setContent($data['content']);
        $this->setCreatedAt($data['created_at']);
    }

    public function setUsername(?string $username = null): void
    {
        $this->username = $username;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setContent(?string $content = null): void
    {
        $this->content = $content;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setCreatedAt(?int $created_at = null): void
    {
        $this->created_at = $created_at;
    }

    public function getCreatedAt(): ?int
    {
        return $this->created_at;
    }

    public function toArray() {
        return [
            'username' => $this->getUsername(),
            'content' => $this->getContent(),
            'created_at' => $this->getCreatedAt()
        ];
    }

    public function matches($username, $content, $created_at) {
        return $this->username === $username &&
            $this->created_at <= $created_at  &&
            strpos(strtolower($this->content), strtolower($content)) !== false;
    }
}
