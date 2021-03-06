<?php

final class PhluxPHIDTypeVariable extends PhabricatorPHIDType {

  const TYPECONST = 'PVAR';

  public function getTypeConstant() {
    return self::TYPECONST;
  }

  public function getTypeName() {
    return pht('Variable');
  }

  public function newObject() {
    return new PhluxVariable();
  }

  public function loadObjects(
    PhabricatorObjectQuery $query,
    array $phids) {

    return id(new PhluxVariableQuery())
      ->setViewer($query->getViewer())
      ->setParentQuery($query)
      ->withPHIDs($phids)
      ->execute();
  }

  public function loadHandles(
    PhabricatorHandleQuery $query,
    array $handles,
    array $objects) {

    foreach ($handles as $phid => $handle) {
      $variable = $objects[$phid];

      $key = $variable->getVariableKey();

      $handle->setName($key);
      $handle->setFullName(pht('Variable "%s"', $key));
      $handle->setURI("/phlux/view/{$key}/");
    }
  }

  public function canLoadNamedObject($name) {
    return false;
  }

}
