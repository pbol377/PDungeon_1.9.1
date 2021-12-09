<?php
namespace pbol377\dungeon\Mobs;

use pocketmine\entity\Entity;
use pocketmine\Player;
use pocketmine\level\Position;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pbol377\dungeon\Mobs\Base;
use pocketmine\network\mcpe\protocol\ActorEventPacket;
use pbol377\dungeon\Mobs\Arrow_Shootable;

class Base_Entity_Shootable extends Base {

	public $width = 0.9;

	public $height = 0.9;

	public $target = null;

	public $size = 0;

	public $name = "mobs";

	public $target_find_radius = 16;
	
	public $dis = 32;

	protected $speed_factor = null;

	protected $follow_range_sq = 1.2;

	protected $jumpTicks = 0;

	protected $attack_queue = 0;

	public function getPlayersInRadius(Position $pos, int $radius)
	{
		$result = [];
		$c = 1;
		foreach ($pos->level->getPlayers() as $player) {
			if ($pos->distance($player) <= $radius){
				$result[] = $player;
				$c = 2;
			}
		}
		
		if($c == 1){
			return 1;
		}
		else{
			return $result;
		}
		
	}
	
	public function setDistance($dis){
		$this->dis = $dis;
	}

	public $speed = 7/100;

	public function initEntity(): void
	{
		$this->speed_factor = $this->speed;
		parent::initEntity();
	}
	
	public function setSpeed($spd){
		$this->speed = $spd/100;
		}

	public function getName(): string{
		return $this->name;
	}

	public function setName($nm){
		$this->name = $nm;
	}

	final public function onUpdate(int $currentTick): bool
	{
		if ($this->attack_queue > 0)
			$this->attack_queue --;
		if ($this->target == null) {
			$players = $this->getPlayersInRadius($this, 100);
			$distance = 100;
			if($players == 1){
				$this->kill();
				$this->close();
			}
			else{
				foreach ($players as $player) {
					if ($this->dis > $this->distance($player)) {
						$distance = $this->distance($player);
						$this->target = $player;
					}
				}
			}
		}
		if ($this->target !== null and ! $this->closed and $this->target instanceof Player) {
			if ($this->level instanceof Level and $this->target->level instanceof Level) {
				if ($this->level->getFolderName() == $this->target->level->getFolderName()) {
					if ($this->target instanceof Vector3 and $this instanceof Vector3) {
						if ($this->target->distance($this) > $this->dis) {
							$this->target = null;
						}
					} else {
						$this->target = null;
					}
					if ($this->target instanceof Vector3 and $this instanceof Vector3) {
						if ($this->target !== null) {
							if ($this->target->distance($this) < 10) {
								
							}
						}
					} else {
						$this->target = null;
					}
					if ($this->isUnderwater()) {
						if ($this->target->distance($this) >= 10) {
						if ($this->target !== null)
						$this->followBySwim($this->target);
						}
					} else {
						if ($this->isCollidedHorizontally) {
							$this->jump();
						}
						if ($this->target !== null){
						if ($this->target->distance($this) >= 10) {
								
							$this->followByWalking($this->target);
							$this->target->sendMessage("hdjsjsjsjjsjs");
							}
						}
					}
		$nbt = new CompoundTag("", [
				new ListTag("Pos", [
						new DoubleTag("", $this->getX()),
						new DoubleTag("", $this->getY()),
						new DoubleTag("", $this->getZ())
				]),
				new ListTag("Motion", [
						new DoubleTag("", 0),
						new DoubleTag("", 0),
						new DoubleTag("", 0)
				]),
				new ListTag("Rotation", [
						new FloatTag("", 0),
						new FloatTag("", 0)
				])
		]);
					if ($this->attack_queue == 15) {
						if ($this->target instanceof Vector3 and $this instanceof Vector3) {
							if ($this->distance($this->target) <= 10) {
								if ($this->target !== null){
									$this->target->attack(new EntityDamageByEntityEvent($this, $this->target, EntityDamageByEntityEvent::CAUSE_ENTITY_ATTACK, (float)$this->size));
									$entity = Entity::createEntity("Arrow_Shootable", $this->getLevel(), $nbt);
									$entity->setTarget($this->target);
									$entity->spawnToAll();
									$this->attack_queue = 0;
								}
							}
						} else {
							$this->target = null;
						}
					}
					else{
						$this->attack_queue++;
					}

					parent::onUpdate($currentTick);
					return true;
				} else {
					$this->target = null;
				}
			} else {

				$this->target = null;
			}
		}
		return false;
	}

	public function jump(): void
	{
		parent::jump();
	}

	public function followBySwim(Entity $target, float $xOffset = 0.0, float $yOffset = 0.0, float $zOffset = 0.0): void
	{
		if ($target !== null) {
			$x = $target->x + $xOffset - $this->x;
			$y = $target->y + $yOffset - $this->y;
			$z = $target->z + $zOffset - $this->z;
			$xz_sq = $x * $x + $z * $z;
			$xz_modulus = sqrt($xz_sq);
			if ($xz_sq < $this->follow_range_sq) {
				$this->motion->x = 0;
				$this->motion->z = 0;
			} else {
				$speed_factor = $this->speed;
				$this->motion->x = $speed_factor * ($x / $xz_modulus);
				$this->motion->z = $speed_factor * ($z / $xz_modulus);
			}

			if ($y !== 0.0) {
				$this->motion->y = 0.1 * $y;
			}

			$this->yaw = rad2deg(atan2(- $x, $z));
			$this->pitch = rad2deg(- atan2($y, $xz_modulus));

			$this->move($this->motion->x, $this->motion->y, $this->motion->z);
		}
	}

	public function followByWalking(Entity $target, float $xOffset = 0.0, float $yOffset = 0.0, float $zOffset = 0.0): void
	{
		if ($target !== null) {
			$x = $target->x + $xOffset - $this->x;
			$y = $target->y + $yOffset - $this->y;
			$z = $target->z + $zOffset - $this->z;
			$xz_sq = $x * $x + $z * $z;
			$xz_modulus = sqrt($xz_sq);
			if ($xz_sq < $this->follow_range_sq) {
				$this->motion->x = 0;
				$this->motion->z = 0;
			} else {

				$speed_factor = $this->speed;
				$this->motion->x = $speed_factor * ($x / $xz_modulus);
				$this->motion->z = $speed_factor * ($z / $xz_modulus);
			}
			$this->yaw = rad2deg(atan2(- $x, $z));
			$this->pitch = rad2deg(- atan2($y, $xz_modulus));
			$this->move($this->motion->x, $this->motion->y, $this->motion->z);
		}
	}

	public function setDamage($size2){
		$this->size = $size2;
		return;
	}

	public function setOwner(Player $owner)
	{
		$this->owner = $owner;
	}
}
