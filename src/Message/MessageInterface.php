<?php
/**
 * This file is part of the Notifier package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Notifier\Message;

use Notifier\ParameterBag\ParameterBagInterface;
use Notifier\Type\TypeInterface;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
interface MessageInterface
{
    /**
     * Set the message type.
     *
     * @param TypeInterface $type
     */
    public function setType(TypeInterface $type);

    /**
     * Get the message type.
     *
     * @return TypeInterface
     */
    public function getType();

    /**
     * Get all the attached ParameterBags.
     *
     * @return ParameterBagInterface[]
     */
    public function getParameterBags();

    /**
     * Get a specific ParameterBag based on identifier.
     *
     * @param string $identifier
     * @return ParameterBagInterface
     */
    public function getParameterBag($identifier);

    /**
     * Check if this message has a specific ParameterBag.
     *
     * @param string $identifier
     * @return bool
     */
    public function hasParameterBag($identifier);

    /**
     * Add a ParameterBag.
     *
     * @param ParameterBagInterface $bag
     */
    public function addParameterBag(ParameterBagInterface $bag);
}
