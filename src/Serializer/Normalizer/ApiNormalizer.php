<?php

namespace App\Serializer\Normalizer;

use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\Api\IriConverterInterface;
use App\Entity\Question;

final class ApiNormalizer implements NormalizerInterface, DenormalizerInterface, SerializerAwareInterface
{
  private $decoratedNormalizer;
  private $em;
  private $iriConverter;

  public function __construct(NormalizerInterface $decoratedNormalizer, EntityManagerInterface $em, IriConverterInterface $iriConverter)
  {
    $this->em = $em;
    $this->decoratedNormalizer = $decoratedNormalizer;
    $this->iriConverter = $iriConverter;
  }


  public function supportsNormalization($data, string $format = null)
  {
    return $this->decoratedNormalizer->supportsNormalization($data, $format);
  }

  public function supportsDenormalization($data, $type, string $format = null)
  {
    return $this->decorated->supportsDenormalization($data, $type, $format);
  }

  public function normalize($object, string $format = null, array $context = [])
  {

    $data = $this->decoratedNormalizer->normalize($object, $format, $context);
    if (is_array($data) && $object instanceof Question) {
      foreach ($object->getPlaceholders() as $i => $placeholder) {
        if ($placeholder->getContenu()) {
          $data['placeholders'][$i] = $placeholder->getContenu();
        }
      }
      if ($object->getData()) {
        $data['dataName'] = $object->getData()->getNomData();
      }
      foreach ($object->getChoice() as $i => $choice) {
        if ($choice->getNextStep()) {
          $data['choices'][$i]['nextStep'] = $choice->getNextStep()->getOrdre();
        }
        if ($choice->getLabel()) {
          $data['choices'][$i]['label'] = $choice->getLabel();
        }
        if ($choice->getDescription()) {
          $data['choices'][$i]['description'] = $choice->getDescription();
        }
        if ($choice->getImages()) {
          $data['choices'][$i]['images'] = $choice->getImages();
        }
      }
    }
    return $data;
  }

  public function denormalize($data, $class, string $format = null, array $context = array())
  {
    return $this->decoratedNormalizer->denormalize($data, $class, $format, $context);
  }

  public function setSerializer(SerializerInterface $serializer)
  {
    if ($this->decoratedNormalizer instanceof SerializerAwareInterface) {
      $this->decoratedNormalizer->setSerializer($serializer);
    }
  }

  private function createPlayer($identifier)
  {
  }
}
