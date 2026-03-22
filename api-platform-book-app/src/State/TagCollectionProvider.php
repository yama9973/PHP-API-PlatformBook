<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\{ArrayPaginator, Pagination};
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Tag;

class TagCollectionProvider implements ProviderInterface
{
    public function __construct(private Pagination $pagination) {}
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        // Retrieve the state from somewhere
        $tags = array_map(
            fn(string $tag, int $i) => new Tag($i + 1, $tag),
            Tag::ALLOWED_TAGS,
            array_keys(Tag::ALLOWED_TAGS),
        );

        $offset = $this->pagination->getOffset($operation, $context);
        $limit = $this->pagination->getLimit($operation, $context);

        return new ArrayPaginator($tags, $offset, $limit);
    }
}
