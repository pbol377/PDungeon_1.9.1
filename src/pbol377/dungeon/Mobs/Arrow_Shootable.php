<?php
declare(strict_types = 1);

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

class Arrow_Shootable extends Base {
	const NETWORK_ID = 80;

	public $width = 0.9;

	public $height = 0.9;

	public $target = null;

	public $size = 0;

	public $name = "Arrow";
	
	public $dis = 32;
	
	public $x1 = 0;
	
	public $z1 = 0;
	
	public $y1 = 0;

	protected $speed_factor = null;

	protected $follow_range_sq = 1.2;

	protected $jumpTicks = 0;

	protected $attack_queue = 0;

	public $speed = 7/100;

	public function initEntity(): void
	{
		$this->speed_factor = $this->speed;
		parent::initEntity();
	}
	
	public function getName(): string{
		return $this->name;
	}

	public function setName($nm){
		$this->name = $nm;
	}
	
	public function setTarget(Player $player){
		$this->target = $player;
	}

	final public function onUpdate(int $currentTick): bool
	{
		if ($this->target !== null and ! $this->closed and $this->target instanceof Player) {
			if ($this->level instanceof Level and $this->target->level instanceof Level) {
				if ($this->level->getFolderName() == $this->target->level->getFolderName()) {
					if ($this->target->distance($this) > 1) {
						$this->target = null;
						$this->kill();
						$this->close();
					}
					else{
						if($this->attack_queue == 0){
							$x = $this->target->x - $this->x;
							$z = $this->target->z - $this->z;
							$y = $this->target->y - $this->y;
							$range_xzy = sqrt($x*$x + $z*$z + $y*$y);
							$this->motion->x = 7 * $x / $range_xzy;
							$this->motion->z = 7 * $z / $range_xzy;
							$this->motion->y = 7 * $y / $range_xzy;
							for($i = 20; $i >= 0; $i--){
								$this->move($this->motion->x, $this->motion->y/20*$i, $this->motion->z);
							}
						}
						else{
							//$this->attack_queue++;
						}
					}
				}
				else{
					$this->target = null;
				}
			}
			else{
				$this->target = null;
			}
		}
	}

	public function setDamage($size2){
		$this->size = $size2;
		return;
	}
}