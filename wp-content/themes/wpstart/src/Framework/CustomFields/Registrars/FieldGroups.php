<?php

namespace WPStart\Framework\CustomFields\Registrars;

use InvalidArgumentException;
use WPStart\Framework\CustomFields\Contracts\FieldGroup;

use function WPStart\Framework\ServiceContainer\app;

/**
 * The custom field group registrar.
 *
 * @unreleased
 */
class FieldGroups
{
    /**
     * Field groups registry.
     *
     * @unreleased
     *
     * @var string[] Array of fully-qualified FieldGroup class names.
     */
    private array $fieldGroups = [];

    /**
     * Get all the registered field groups.
     *
     * @unreleased
     *
     * @return string[]
     */
    public function getAll(): array
    {
        return $this->fieldGroups;
    }

    /**
     * Add a field group to the registry.
     *
     * @unreleased
     *
     * @param string $fieldGroup Fully-qualified FieldGroup class name.
     */
    public function addOne(string $fieldGroup): void
    {
        if ( ! is_subclass_of($fieldGroup, FieldGroup::class)) {
            throw new InvalidArgumentException("$fieldGroup must extend " . FieldGroup::class);
        }

        $this->fieldGroups[] = $fieldGroup;
    }

    /**
     * Add field groups to the registry.
     *
     * @unreleased
     *
     * @param string[] $fieldGroups Array of fully-qualified FieldGroup class names.
     */
    public function add(array $fieldGroups): void
    {
        foreach ($fieldGroups as $fieldGroup) {
            $this->addOne($fieldGroup);
        }
    }

    /**
     * Register field groups.
     *
     * @unreleased
     */
    public function register(): void
    {
        $fieldGroups = $this->getAll();

        foreach ($fieldGroups as $fieldGroup) {
            /** @var FieldGroup $instance */
            $instance = app($fieldGroup);
            $instance->register();
        }
    }
}
