<?php
declare(strict_types = 1);

namespace App\Infrastructure\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation as OpenApiOperation;
use App\Domain\Exception\UserNotFoundException;
use App\Infrastructure\Processor\UserCreateProcessor;
use App\Infrastructure\Processor\UserDeleteProcessor;
use App\Infrastructure\Provider\UserCollectionProvider;
use App\Infrastructure\Provider\UserProvider;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Get(
            uriVariables: [
                'id' => new Link(
                    parameterName: 'id',
                    description: 'Идентификатор пользователя в формате RFC 4122',
                    required: true,
                ),
            ],
            status: 200,
            openapi: new OpenApiOperation(
                summary: 'Получить пользователя по id',
                description: 'Получить пользователя по id',
            ),
            description: 'Получить пользователя по id',
            normalizationContext: ['groups' => [self::USER_OUTPUT]],
            provider: UserProvider::class,
        ),
        new GetCollection(
            status: 200,
            openapi: new OpenApiOperation(
                summary: 'Получить список пользователей',
                description: 'Получить список пользователей с пагинацией',
            ),
            description: 'Получить список пользователей с пагинацией',
            normalizationContext: ['groups' => [self::USER_OUTPUT]],
            paginationEnabled: true,
            paginationClientItemsPerPage: true,
            paginationItemsPerPage: 10,
            paginationMaximumItemsPerPage: 50,
            provider: UserCollectionProvider::class,
        ),
        new Post(
            status: 201,
            openapi: new OpenApiOperation(
                summary: 'Создать пользователя',
                description: 'Создать пользователя',
            ),
            description: 'Создать пользователя',
            normalizationContext: ['groups' => [self::USER_OUTPUT]],
            denormalizationContext: ['groups' => [self::USER_INPUT]],
            validationContext: ['groups' => [self::USER_INPUT]],
            processor: UserCreateProcessor::class,
        ),
        new Delete(
            uriVariables: [
                'id' => new Link(
                    parameterName: 'id',
                    description: 'Идентификатор пользователя в формате RFC 4122',
                    required: true,
                ),
            ],
            status: 204,
            openapi: new OpenApiOperation(
                summary: 'Удалить пользователя по id',
                description: 'Удалить пользователя по id',
            ),
            description: 'Удалить пользователя по id',
            read: false,
            processor: UserDeleteProcessor::class,
        ),
    ],
    exceptionToStatus: [
        UserNotFoundException::class => 404,
    ],
)]
final class User
{
    public const string USER_OUTPUT = 'userDefaultOutput';
    public const string USER_INPUT  = 'userDefaultInput';

    #[Groups([self::USER_OUTPUT])]
    #[Assert\Ulid]
    public ?string $id = null;

    #[Groups([self::USER_OUTPUT, self::USER_INPUT])]
    #[Assert\Email(groups: [self::USER_INPUT])]
    public string $email;

    #[Groups([self::USER_OUTPUT, self::USER_INPUT])]
    #[Assert\NotBlank(groups: [self::USER_INPUT])]
    public string $name;

    #[Groups([self::USER_OUTPUT])]
    public ?\DateTimeImmutable $createdAt = null;

    #[Groups([self::USER_OUTPUT])]
    public ?\DateTimeImmutable $updatedAt = null;
}
