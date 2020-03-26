<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
* Users Model
*
* @method \App\Model\Entity\User newEmptyEntity()
* @method \App\Model\Entity\User newEntity(array $data, array $options = [])
* @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
* @method \App\Model\Entity\User get($primaryKey, $options = [])
* @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
* @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
* @method \App\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
* @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
* @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
* @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
* @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
* @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
* @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
*/
class UsersTable extends Table
{
  /**
  * Initialize method
  *
  * @param array $config The configuration for the Table.
  * @return void
  */
  public function initialize(array $config): void
  {
    parent::initialize($config);

    $this->setTable('users');
    $this->setPrimaryKey('id');
  }

  /**
  * Default validation rules.
  *
  * @param \Cake\Validation\Validator $validator Validator instance.
  * @return \Cake\Validation\Validator
  */
  public function validationDefault(Validator $validator): Validator
  {
    $validator
    ->integer('id')
    ->allowEmptyString('id', null, 'create');

    $validator
    ->scalar('name')
    ->maxLength('name', 80)
    ->requirePresence('name', 'create')
    ->notEmptyString('name');

    $validator
    ->email('email')
    ->requirePresence('email', 'create')
    ->notEmptyString('email');

    $validator
    ->scalar('password')
    ->maxLength('password', 255)
    ->requirePresence('password', 'create')
    ->notEmptyString('password');

    $validator
    ->dateTime('created_at')
    ->notEmptyDateTime('created_at');

    $validator
    ->dateTime('updated_at')
    ->notEmptyDateTime('updated_at');

    return $validator;
  }

  /**
  * Returns a rules checker object that will be used for validating
  * application integrity.
  *
  * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
  * @return \Cake\ORM\RulesChecker
  */
  public function buildRules(RulesChecker $rules): RulesChecker
  {
    $rules->add($rules->isUnique(['email']));

    return $rules;
  }

  public function findAuth(Query $query, array $options)
  {
    $query
    ->select(['id', 'email', 'password']);

    return $query;
  }
}