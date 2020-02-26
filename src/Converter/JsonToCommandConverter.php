<?php
declare(strict_types=1);

namespace App\Converter;

use App\Contract\JsonInputInterface;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class JsonToCommandConverter implements ParamConverterInterface
{
    private NormalizerInterface $normalizer;

    public function __construct(NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $payload = json_decode($request->getContent(), true);

        if (null === $payload) {
            throw new InvalidArgumentException('JSON input data is not valid.');
        }

        $command = $this->normalizer->denormalize($payload, $configuration->getClass());

        $request->attributes->set($configuration->getName(), $command);

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        if (null === $configuration->getClass()) {
            return false;
        }

        $interfaces = class_implements($configuration->getClass());

        if (isset($interfaces[JsonInputInterface::class])) {
            return true;
        }

        return false;
    }
}
