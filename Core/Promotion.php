<?php

namespace ScAnalytics\Core;

/**
 * Class Promotion. Represents a promotional element.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 */
class Promotion
{

    /**
     * @var string|null The ID of the promotion. Name must be given, if null
     */
    private $id;

    /**
     * @var string|null $name The name of the promotion. ID must be given, if null
     */
    private $name;

    /**
     * @var string|null $creative The name of the creative element of the promotion
     */
    private $creative;

    /**
     * @var string|null $position The position of the promotion on the page
     */
    private $position;

    /**
     * @param string|null $id The ID of the promotion. Name must be given, if null
     * @param string|null $name The name of the promotion. ID must be given, if null
     * @param string|null $creative The name of the creative element of the promotion
     * @param string|null $position The position of the promotion on the page
     */
    public function __construct(?string $id, ?string $name, ?string $creative, ?string $position)
    {
        $this->id = $id;
        $this->name = $name;
        $this->creative = $creative;
        $this->position = $position;
    }

    /**
     * @return string|null The ID of the promotion. Name must be given, if null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return string|null $name The name of the promotion. ID must be given, if null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null $creative The name of the creative element of the promotion
     */
    public function getCreative(): ?string
    {
        return $this->creative;
    }

    /**
     * @return string|null $position The position of the promotion on the page
     */
    public function getPosition(): ?string
    {
        return $this->position;
    }

}