<?php
namespace pbol377\dungeon;

use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\scheduler\Task;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\ModalFormRequestPacket;
use pocketmine\network\mcpe\protocol\ModalFormResponsePacket;
use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDeathEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Internet;
/*
 *  Custom Mob Reffered CSZombie || By Pbol377
 */
use pbol377\dungeon\Mobs\Silverfish_entity;
use pbol377\dungeon\Mobs\Cow_entity;
use pbol377\dungeon\Mobs\Drowned_entity;
use pbol377\dungeon\Mobs\Vex_entity;
use pbol377\dungeon\Mobs\Pig_entity;
use pbol377\dungeon\Mobs\Sheep_entity;
use pbol377\dungeon\Mobs\Wolf_entity;
use pbol377\dungeon\Mobs\Villager_entity;
use pbol377\dungeon\Mobs\Mooshroom_entity;
use pbol377\dungeon\Mobs\Squid_entity;
use pbol377\dungeon\Mobs\Rabbit_entity;
use pbol377\dungeon\Mobs\Bat_entity;
use pbol377\dungeon\Mobs\Iron_golem_entity;
use pbol377\dungeon\Mobs\Snow_golem_entity;
use pbol377\dungeon\Mobs\Ocelot_entity;
use pbol377\dungeon\Mobs\Horse_entity;
use pbol377\dungeon\Mobs\Donkey_entity;
use pbol377\dungeon\Mobs\Mule_entity;
use pbol377\dungeon\Mobs\Skeleton_horse_entity;
use pbol377\dungeon\Mobs\Zombie_horse_entity;
use pbol377\dungeon\Mobs\Polar_bear_entity;
use pbol377\dungeon\Mobs\Llama_entity;
use pbol377\dungeon\Mobs\Parrot_entity;
use pbol377\dungeon\Mobs\Dolphin_entity;
use pbol377\dungeon\Mobs\Zombie_entity;
use pbol377\dungeon\Mobs\Creeper_entity;
use pbol377\dungeon\Mobs\Skeleton_entity;
use pbol377\dungeon\Mobs\Spider_entity;
use pbol377\dungeon\Mobs\Zombie_pigman_entity;
use pbol377\dungeon\Mobs\Slime_entity;
use pbol377\dungeon\Mobs\Enderman_entity;
use pbol377\dungeon\Mobs\Cave_spider_entity;
use pbol377\dungeon\Mobs\Ghast_entity;
use pbol377\dungeon\Mobs\Magma_cube_entity ;
use pbol377\dungeon\Mobs\Blaze_entity;
use pbol377\dungeon\Mobs\Zombie_villager_entity;
use pbol377\dungeon\Mobs\Witch_entity;
use pbol377\dungeon\Mobs\Stray_entity;
use pbol377\dungeon\Mobs\Husk_entity;
use pbol377\dungeon\Mobs\Wither_skeleton_entity;
use pbol377\dungeon\Mobs\Guardian_entity;
use pbol377\dungeon\Mobs\Elder_gaurdian_entity;
use pbol377\dungeon\Mobs\Wither_entity;
use pbol377\dungeon\Mobs\Ender_dragon_entity;
use pbol377\dungeon\Mobs\Shulker_entity;
use pbol377\dungeon\Mobs\Endermite_entity;
use pbol377\dungeon\Mobs\Agent_entity;
use pbol377\dungeon\Mobs\Vindicator_entity;
use pbol377\dungeon\Mobs\Phantom_entity;
use pbol377\dungeon\Mobs\Ravager_entity;
use pbol377\dungeon\Mobs\Armor_stand_entity;
use pbol377\dungeon\Mobs\Tripod_camera_entity;
use pbol377\dungeon\Mobs\Item_entity;
use pbol377\dungeon\Mobs\Tnt_entity;
use pbol377\dungeon\Mobs\Falling_block_entity;
use pbol377\dungeon\Mobs\Xp_bottle_entity;
use pbol377\dungeon\Mobs\Xp_orb_entity;
use pbol377\dungeon\Mobs\Eye_of_ender_signal_entity;
use pbol377\dungeon\Mobs\Fireworks_rocket_entity;
use pbol377\dungeon\Mobs\Thrown_trident_entity;
use pbol377\dungeon\Mobs\Turtle_entity;
use pbol377\dungeon\Mobs\Cat_entity;
use pbol377\dungeon\Mobs\Shulker_bullet_entity;
use pbol377\dungeon\Mobs\Fishing_hook_entity;
//use pbol377\dungeon\Mobs\Dragon_fireball;
use pbol377\dungeon\Mobs\Arrow_entity;
use pbol377\dungeon\Mobs\Snowball_entity;
use pbol377\dungeon\Mobs\Egg_entity;
use pbol377\dungeon\Mobs\Boat_entity;
use pbol377\dungeon\Mobs\Minecart_entity;
use pbol377\dungeon\Mobs\Tnt_minecart_entity;
use pbol377\dungeon\Mobs\Chest_minecart_entity;
use pbol377\dungeon\Mobs\Panda_entity;
use pbol377\dungeon\Mobs\Chicken_entity;
use pbol377\dungeon\Mobs\Base_Entity;
//use pbol377\dungeon\Mobs\Base_Entity_Attack;
//use pbol377\dungeon\Mobs\Bee;
use pbol377\dungeon\Mobs\Base;
use pocketmine\entity\Monster;

class Main extends PluginBase implements Listener{
	
	public $delete = [];
	
	public $edit = [];
	
	public $award = [];
	
	public $height = 0.9;
	
	public $width = 0.9;
	
	public $getawardA = [];
	
	public $getawardB = [];
	
	public $getdel = [];
	
	public $getedit = [];
	
	public $getposA = [];
	
	public $getposB = [];
	
	public $mobs = [
			"Chicken_entity",
			"Boat_entity",
			"Minecart_entity",
			"Tnt_minecart_entity",
			"Chest_minecart_entity",
			"Panda_entity",
			"Husk_entity",
			"Cow_entity",
			"Pig_entity",
			"Sheep_entity",
			"Wolf_entity",
			"Villager_entity",
			"Mooshroom_entity",
			"Squid_entity",
			"Rabbit_entity",
			"Bat_entity",
			"Iron_golem_entity",
			"Snow_golem_entity",
			"Ocelot_entity",
			"Horse_entity",
			"Donkey_entity",
			"Mule_entity",
			"Skeleton_horse_entity",
			"Zombie_horse_entity",
			"Polar_bear_entity",
			"Llama_entity",
			"Parrot_entity",
			"Dolphin_entity",
			"Zombie_entity",
			"Creeper_entity",
			"Skeleton_entity",
			"Spider_entity",
			"Zombie_pigman_entity",
			"Slime_entity",
			"Enderman_entity",
			"Silverfish_entity",
			"Cave_spider_entity",
			"Ghast_entity",
			"Magma_cube_entity",
			"Blaze_entity",
			"Zombie_villager_entity",
			"Witch_entity",
			"Stray_entity",
			"Wither_skeleton_entity",
			"Guardian_entity",
			"Elder_gaurdian_entity",
			"Wither_entity",
			"Ender_dragon_entity",
			"Shulker_entity",
			"Endermite_entity",
			"Agent_entity",
			"Vindicator_entity",
			"Phantom_entity",
			"Ravager_entity",
			"Armor_stand_entity",
			"Tripod_camera_entity",
			"Item_entity_entity",
			"Tnt_entity",
			"Falling_block_entity",
			"Xp_bottle_entity",
			"Xp_orb_entity",
			"Eye_of_ender_signal_entity",
			"Fireworks_rocket_entity",
			"Thrown_trident_entity",
			"Turtle_entity",
			"Cat_entity",
			"Shulker_bullet_entity",
			"Fishing_hook_entity",
			"Arrow_entity",
			"Snowball_entity",
			"Egg_entity",
			"Drowned_entity",
			"Vex_entity",
	];
	
	public function onEnable() {
		$this->getServer()->getPluginManager()->registerEvents ($this, $this);
		$this->data = new Config($this->getDataFolder() . "data.yml", Config::YAML);
		$this->db = $this->data->getAll();
		if(!isset($this->db))$this->db = [];
		//var_dump($this->mobs);
		/*foreach ($this->mobs as $key => $val){
			//Entity::registerEntity($val::class, true);
		}*/
		
		//Entity::registerEntity(Bee::class, true);
		Entity::registerEntity(Drowned_entity::class, true);
		Entity::registerEntity(Vex_entity::class, true);
		Entity::registerEntity(Chicken_entity::class, true);
		Entity::registerEntity(Boat_entity::class, true);
		Entity::registerEntity(Minecart_entity::class, true);
		Entity::registerEntity(Tnt_minecart_entity::class, true);
		Entity::registerEntity(Chest_minecart_entity::class, true);
		Entity::registerEntity(Panda_entity::class, true);
		Entity::registerEntity(Husk_entity::class, true);
		Entity::registerEntity(Cow_entity::class, true);
		Entity::registerEntity(Pig_entity::class, true);
		Entity::registerEntity(Sheep_entity::class, true);
		Entity::registerEntity(Wolf_entity::class, true);
		Entity::registerEntity(Villager_entity::class, true);
		Entity::registerEntity(Mooshroom_entity::class, true);
		Entity::registerEntity(Squid_entity::class, true);
		Entity::registerEntity(Rabbit_entity::class, true);
		Entity::registerEntity(Bat_entity::class, true);
		Entity::registerEntity(Iron_golem_entity::class, true);
		Entity::registerEntity(Snow_golem_entity::class, true);
		Entity::registerEntity(Ocelot_entity::class, true);
		Entity::registerEntity(Horse_entity::class, true);
		Entity::registerEntity(Donkey_entity::class, true);
		Entity::registerEntity(Mule_entity::class, true);
		Entity::registerEntity(Skeleton_horse_entity::class, true);
		Entity::registerEntity(Zombie_horse_entity::class, true);
		Entity::registerEntity(Polar_bear_entity::class, true);
		Entity::registerEntity(Llama_entity::class, true);
		Entity::registerEntity(Parrot_entity::class, true);
		Entity::registerEntity(Dolphin_entity::class, true);
		Entity::registerEntity(Zombie_entity::class, true);
		Entity::registerEntity(Creeper_entity::class, true);
		Entity::registerEntity(Skeleton_entity::class, true);
		Entity::registerEntity(Spider_entity::class, true);
		Entity::registerEntity(Zombie_pigman_entity::class, true);
		Entity::registerEntity(Slime_entity::class, true);
		Entity::registerEntity(Enderman_entity::class, true);
		Entity::registerEntity(Silverfish_entity::class, true);
		Entity::registerEntity(Cave_spider_entity::class, true);
		Entity::registerEntity(Ghast_entity::class, true);
		Entity::registerEntity(Magma_cube_entity::class, true);
		Entity::registerEntity(Blaze_entity::class, true);
		Entity::registerEntity(Zombie_villager_entity::class, true);
		Entity::registerEntity(Witch_entity::class, true);
		Entity::registerEntity(Stray_entity::class, true);
		Entity::registerEntity(Wither_skeleton_entity::class, true);
		Entity::registerEntity(Guardian_entity::class, true);
		Entity::registerEntity(Elder_gaurdian_entity::class, true);
		Entity::registerEntity(Wither_entity::class, true);
		Entity::registerEntity(Ender_dragon_entity::class, true);
		Entity::registerEntity(Shulker_entity::class, true);
		Entity::registerEntity(Endermite_entity::class, true);
		Entity::registerEntity(Agent_entity::class, true);
		Entity::registerEntity(Vindicator_entity::class, true);
		Entity::registerEntity(Phantom_entity::class, true);
		Entity::registerEntity(Ravager_entity::class, true);
		Entity::registerEntity(Armor_stand_entity::class, true);
		Entity::registerEntity(Tripod_camera_entity::class, true);
		Entity::registerEntity(Item_entity::class, true);
		Entity::registerEntity(Tnt_entity::class, true);
		Entity::registerEntity(Falling_block_entity::class, true);
		Entity::registerEntity(Xp_bottle_entity::class, true);
		Entity::registerEntity(Xp_orb_entity::class, true);
		Entity::registerEntity(Eye_of_ender_signal_entity::class, true);
		Entity::registerEntity(Fireworks_rocket_entity::class, true);
		Entity::registerEntity(Thrown_trident_entity::class, true);
		Entity::registerEntity(Turtle_entity::class, true);
		Entity::registerEntity(Cat_entity::class, true);
		Entity::registerEntity(Shulker_bullet_entity::class, true);
		Entity::registerEntity(Fishing_hook_entity::class, true);
		//Entity::registerEntity(Dragon_fireball::class, true);
		Entity::registerEntity(Arrow_entity::class, true);
		Entity::registerEntity(Snowball_entity::class, true);
		Entity::registerEntity(Egg_entity::class, true);
		
		$ttask = new TTask($this);
		$this->getScheduler()-> scheduleRepeatingTask($ttask, 20);
		//$this->auth = $this->getServer ()->getPluginManager ()->getPlugin ( "PAuthority" );
		/*
		if($this->auth->CheckIp("dungeon",(string)Internet::getInternalIP())){
			$this->getServer()->getPluginManager()->disablePlugin($this);
			}
			*/
		
		foreach($this->db as $key => $val){
			if(!isset($this->db[$key]["width"])){
				$this->db[$key]["width"] = 0.9;
			}
			if(!isset($this->db[$key]["height"])){
				$this->db[$key]["height"] = 0.9;
			}
			if(!isset($this->db[$key]["max"])){
				$this->db[$key]["max"] = 1;
			}
			if(!isset($this->db[$key]["exp"])){
				$this->db[$key]["exp"] = 0;
			}
		}
		$this->Api = new Config($this->getDataFolder() . "API.yml", Config::YAML);
		$this->api = $this->Api->getAll();
		if(!isset($this->api[0])) $this->api[0] = 1;
		
		foreach($this->getServer()->getLevels() as $level){
			foreach($level->getEntities() as $entity){
				if($entity instanceof Base_Entity){
						//$entity->setLastDamageCause(new EntityDamageEvent($entity, 4, 1000));
						$entity->kill();
						$entity->close();
				}
			}
		}
		/* $version = json_decode(Internet::getUrl("http://********/", 10), true);
		if($version[0]["version2"] != "1.7.9.4"){
			$this->DoTask();
		}
		


		foreach($this->getServer()->getLevels() as $level){
			foreach($level->getEntities() as $entity){
				if($entity instanceof Base_Entity){
					$entity->kill();
					$entity->close();
				}
			}
		}*/
		foreach ($this->db as $key => $val){
			$this->db[$key]["monster"] = 0;
			$this->db[$key]["count"] = 0;
			$this->db[$key]["cleantime"] = 0;
			if(!strstr($val["id"], "_entity")){
				$this->db[$key]["id"] = $val["id"]."_entity";
				$this->getServer()->broadcastMessage("§l§c[WARNING] 몬스터 ID {$val["id"]}에 _entity를 붙였습니다");
			}
		}
	}
	
	public function onDeath(EntityDeathEvent $event){
		$entity = $event->getEntity();
		if($entity->getLastDamageCause() instanceof EntityDamageByEntityEvent){
			$cause = $entity->getLastDamageCause();
			$player = $cause->getDamager();
			if($player instanceof Player){
				if($entity instanceof Base_Entity){
				$en = $entity->getName();
				if(isset($this->db[$en])){
					if($this->api[0] != 1){
						$type = $this->api[1];
						$lev = $this->getServer ()->getPluginManager ()->getPlugin ( $this->api[0] );
						if($type == 0){
							$lev->addExp($player, $this->db[$en]["exp"]);
						}
						else if($type == 1){
							$lev->addXp($player, $this->db[$en]["exp"]);
						}
						else if ($type == 2){
							$lev->giveExps($player, $this->db[$en]["exp"]);
						}
					}
					$this->db[$en]["monster"]--;
					foreach ($this->db[$en]["item"] as $key => $val){
						$ran = mt_rand(1, 100);
						if($ran <= $val["prob"]){
							$player->getInventory()->addItem(Item::jsonDeserialize($val["nbt"]));
						}
					}
					//$entity->close();
				}
			}
			}
		}
		else{
			if($entity instanceof Base_Entity){
				if($entity->getName() != "mobs"){
					//$this->db[$entity->getName()]["monster"]--;
				}
			}
		}
	}
	
	public function onDamage(EntityDamageEvent $event){
		$entity = $event->getEntity();
		if($entity instanceof Base_Entity){
			foreach($this->db as $key => $val){
				if($entity->getName() == (string)$key){
					$mht = $entity->getMaxHealth();
					$ht = $entity->getHealth();
					/*var_dump($entity->getHealth());
					var_dump($event->getBaseDamage());
					var_dump($ht);*/
					$count = (int)$ht/$mht*10;
					$entity->setNameTag($entity->getName()."\n§c§l♡{$ht} ".str_repeat("§c📕", $count).str_repeat("§7📓", 10-$count));
				}
			}
		}
	}
	
	public function sendUI(Player $p, $c, $d) {
		$pack = new ModalFormRequestPacket();
		$pack->formId = $c;
		$pack->formData = $d;
		$p->dataPacket($pack);
	}
	
	public function onDisable(){
		foreach ($this->getServer()->getLevels() as $level){
			foreach ($level->getEntities() as $entities){
				if($entities instanceof Base_Entity){
					$entities->setLastDamageCause(new EntityDamageEvent($entities, 4, 1000));
				}
			}
		}
		foreach ($this->db as $key => $val){
			$this->db[$key]["monster"] = 0;
			$this->db[$key]["count"] = 0;
			$this->db[$key]["cleantime"] = 0;
		}
		$this->save();
	}
	
	public function save(){
		$this->data->setAll($this->db);
		$this->data->save();
		$this->Api->setAll($this->api);
		$this->Api->save();
	}
	
	public function MainUI() {
	
		$encode = [
				"type" => "form",
				"title" => "§l§6|ll| §7Dungeon §6|ll|",
				"content" => "§l§6|ll| §7메뉴를 선택해 주십시오 §6|ll|\n\n",
				"buttons" => [
						[
								"text" => "§l§6|ll| §0몬스터 생성 §6|ll|",
						],
						[
								"text" => "§l§6|ll| §0몬스터 삭제 §6|ll|",
						],
						[
								"text" => "§l§6|ll| §0몬스터 수정 §6|ll|",
						],
						[
								"text" => "§l§6|ll| §0몬스터 위치설정 §6|ll|",
						],
						[
								"text" => "§l§6|ll| §0몬스터 보상 설정 §6|ll|",
						],
						[
								"text" => "§l§6|ll| §0스폰된 몹 초기화 §6|ll|",
						],
						[
								"text" => "§l§6|ll| §0API 연동하기 §6|ll|",
						],
						[
								"text" => "§l§6|ll| §0닫기 §6|ll|",
						]
				]
		];
		return json_encode($encode);
	}
	
	public function PosUI1() {
		$buttons = [];
		foreach ($this->db as $key => $val){
			$array = array("text"=>(string)$key);
			array_push($buttons, $array);
		}
		$this->getposA = $buttons;
		$array = array("text"=>"§l§6|ll| §0메인 §6|ll|");
		array_push($buttons, $array);
		$array = array("text"=>"§l§6|ll| §0나가기 §6|ll|");
		array_push($buttons, $array);
		
		$encode = [
				"type" => "form",
				"title" => "§l§6|ll| §7Dungeon §6|ll|",
				"content" => "§l§6|ll| §7위치를 설정할 몬스터를 선택하십시오 §6|ll|\n\n",
				"buttons" => $buttons,
		];
		return json_encode($encode);
	}
	
	public function DoTask(){
		$this->getServer()->getPluginManager()->disablePlugin();
	}
	
	public function PosUI2($key) {
		$buttons = [];
		$buttonsB = [];
		foreach ($this->db[$key]["pos"] as $key2 => $val2){
			$e = "§l§7[X좌표]: ".(int)$val2["x"]." || [Y좌표]: ".(int)$val2["y"]." || [Z좌표]: ".(int)$val2["z"]."\n[월드]: ".$val2["lev"];
			$array = array("text"=>$e);
			array_push($buttons, $array);
			array_push($buttonsB, (string)$key2);
		}
		$this->getposB = $buttonsB;
		$array = array("text"=>"§l§6|ll| §0위치 추가 §6|ll|");
		array_push($buttons, $array);
		$array = array("text"=>"§l§6|ll| §0메인 §6|ll|");
		array_push($buttons, $array);
		$array = array("text"=>"§l§6|ll| §0나가기 §6|ll|");
		array_push($buttons, $array);
	
		$encode = [
				"type" => "form",
				"title" => "§l§6|ll| §7Dungeon §6|ll|",
				"content" => "§l§6|ll| §7삭제할 위치를 선택하십시오 §l§6|ll| §7\n§l§6|ll| §7추가 버튼은 하단에 있습니다. §6|ll|\n\n",
				"buttons" => $buttons,
		];
		return json_encode($encode);
	}
	
	public function EditUI1() {
		$buttons = [];
		foreach ($this->db as $key => $val){
			$array = array("text"=>(string)$key);
			array_push($buttons, $array);
		}
		$this->getedit = $buttons;
		$array = array("text"=>"§l§6|ll| §0메인 §6|ll|");
		array_push($buttons, $array);
		$array = array("text"=>"§l§6|ll| §0나가기 §6|ll|");
		array_push($buttons, $array);
	
		$encode = [
				"type" => "form",
				"title" => "§l§6|ll| §7Dungeon §6|ll|",
				"content" => "§l§6|ll| §7수정할 몬스터를 선택하십시오 §6|ll|\n\n",
				"buttons" => $buttons,
		];
		return json_encode($encode);
	}
	
	public function EditUI2($key) {
		$encode = [
				"type" => "custom_form",
				"title" => "§l§6|ll| §7Dungeon §6|ll|",
				"content" => [
						[
								"type" => "input",
								"text" =>  "§l§6|ll| §7몬스터 아이디를 적어주세요 (건드리지 마세요) §6|ll|",
								"default"=> $this->db[$key]["id"],
						],
						[
								"type" => "input",
								"text" => "§l§6|ll| §7몬스터 이름을 입력해주세요 §6|ll|",
								"default"=> (string)$key,
						],
						[
								"type" => "input",
								"text" => "§l§6|ll| §7몬스터 체력을 입력해주세요 §6|ll|",
								"default"=> $this->db[$key]["health"]
						],
						[
								"type" => "input",
								"text" => "§l§6|ll| §7몬스터 공격력 적어주세요 §6|ll|",
								"default"=> $this->db[$key]["attack"]
						],
						[
								"type" => "input",
								"text" => "§l§6|ll| §7몬스터 크기를 적어주세요 §6|ll|",
								"default"=> $this->db[$key]["size"]
						],
						[
								"type" => "input",
								"text" => "§l§6|ll| §7몬스터 스폰 주기를 적어주세요 §6|ll|",
								"default"=> $this->db[$key]["spawn"]
						],
						[
								"type" => "input",
								"text" => "§l§6|ll| §7몬스터 속도를 적어주세요 (기본값 7~11) §6|ll|",
								"default"=> $this->db[$key]["speed"]
						],
						[
								"type" => "input",
								"text" => "§l§6|ll| §7몬스터 인식 범위를 적어주세요 (기본값 32) §6|ll|",
								"default"=> $this->db[$key]["range"]
						],
						[
								"type" => "input",
								"text" => "§l§6|ll| §7몬스터 최대 스폰수를 적어주세요 §6|ll|",
								"default"=> (string)$this->db[$key]["max"]
						],
						[
								"type" => "input",
								"text" => "§l§6|ll| §7몬스터 너비를 적어주세요 (권장값: 0.9) §6|ll|",
								"default"=> $this->db[$key]["width"]
						],
						[
								"type" => "input",
								"text" => "§l§6|ll| §7몬스터 높이를 적어주세요 (권장값: 0.9) §6|ll|",
								"default"=> $this->db[$key]["height"]
						],
						[
								"type" => "input",
								"text" => "§l§6|ll| §7몬스터 청소 주기를 적어주세요 (초) §6|ll|",
								"default"=> $this->db[$key]["clean"]
						],
						[
								"type" => "input",
								"text" => "§l§6|ll| §7몬스터 경험치를 적어주세요 §6|ll|",
								"default"=> $this->db[$key]["exp"]
						],
						[
								"type" => "input",
								"text" => "§l§6|ll| §7색코드를 지원하는 몬스터의 색코드를 적어주세요 (판다 0~6 | 앵무새 0~4) 만약 없으면 [-1]을 유지해주세요 §6|ll|",
								"default"=> (string)$this->db[$key]["color"]
						],
				]
		];
		return json_encode($encode);
	}
	
	public function AwardUI1() {
		$buttons = [];
		foreach ($this->db as $key => $val){
			$array = array("text"=>(string)$key);
			array_push($buttons, $array);
		}
		$this->getawardA = $buttons;
		$array = array("text"=>"§l§6|ll| §0메인 §6|ll|");
		array_push($buttons, $array);
		$array = array("text"=>"§l§6|ll| §0나가기 §6|ll|");
		array_push($buttons, $array);
	
		$encode = [
				"type" => "form",
				"title" => "§l§6|ll| §7Dungeon §6|ll|",
				"content" => "§l§6|ll| §7보상을 설정할 몬스터를 선택하십시오 §6|ll|\n\n",
				"buttons" => $buttons,
		];
		return json_encode($encode);
	}
	
	public function AwardUI2($key) {
		$buttons = [];
		$buttonsB = [];
		foreach ($this->db[$key]["item"] as $key2 => $val2){
			if(isset($this->db[$key]["item"][$key2]["nbt"]["nbt_b64"])){
				$item = Item::jsonDeserialize($val2["nbt"]);
				$name = $item->getCustomName();
			}
			else{
				$name = "없음";
			}
			if(isset($this->db[$key]["item"][$key2]["nbt"]["damage"])){
				$damage = $this->db[$key]["item"][$key2]["nbt"]["damage"];
			}
			else{
				$damage = "0";
			}
			if(isset($this->db[$key]["item"][$key2]["nbt"]["count"])){
				$count = $this->db[$key]["item"][$key2]["nbt"]["count"];
			}
			else{
				$count = 1;
			}
			$e = "§l§7[아이디]: ".$this->db[$key]["item"][$key2]["nbt"]["id"]." [데미지]: ".$damage." [수량]: ".$count."\n[이름]: ".$name." §7[확률]: ".$this->db[$key]["item"][$key2]["prob"]."%";          																		
			$array = array("text"=>$e);
			array_push($buttons, $array);
			array_push($buttonsB, (string)$key2);
		}
		$this->getawardB = $buttonsB;
		$array = array("text"=>"§l§6|ll| §0보상 추가 §6|ll|");
		array_push($buttons, $array);
		$array = array("text"=>"§l§6|ll| §0메인 §6|ll|");
		array_push($buttons, $array);
		$array = array("text"=>"§l§6|ll| §0나가기 §6|ll|");
		array_push($buttons, $array);
	
		$encode = [
				"type" => "form",
				"title" => "§l§6|ll| §7Dungeon §6|ll|",
				"content" => "§l§6|ll| §7삭제할 보상을 선택하십시오 §l§6|ll| §7\n§l§6|ll| §7추가 버튼은 하단에 있습니다. §6|ll|\n\n",
				"buttons" => $buttons,
		];
		return json_encode($encode);
	}
	
	public function AwardUI3() {
		$encode = [
				"type" => "custom_form",
				"title" => "§l§6|ll| §7Dungeon §6|ll|",
				"content" => [
						[
								"type" => "input",
								"text" =>  "§l§6|ll| §7보상 확률을 입력하세요 (%%) §6|ll|",
						],
				]
		];
		return json_encode($encode);
	}
	
	public function MakeUI() {
		$encode = [
				"type" => "custom_form",
				"title" => "§l§6|ll| §7Dungeon §6|ll|",
				"content" => [
						[
								"type" => "dropdown",
								"text" =>  "§l§6|ll| §7몬스터 아이디를 선택해주세요 §6|ll|",
								"options"=>$this->mobs,
						],
						[
								"type" => "input",
								"text" => "§l§6|ll| §7몬스터 이름을 입력해주세요 §6|ll|",
						],
						[
								"type" => "input",
								"text" => "§l§6|ll| §7몬스터 체력을 입력해주세요 §6|ll|",
						],
						[
								"type" => "input",
								"text" => "§l§6|ll| §7몬스터 공격력 적어주세요 §6|ll|",
						],
						[
								"type" => "input",
								"text" => "§l§6|ll| §7몬스터 크기를 적어주세요 §6|ll|",
								"default"=>"1"
						],
						[
								"type" => "input",
								"text" => "§l§6|ll| §7몬스터 스폰 주기를 적어주세요 (초)§6|ll|",
						],
						[
								"type" => "input",
								"text" => "§l§6|ll| §7몬스터 속도를 적어주세요 (권장값 7~11) §6|ll|",
								"default"=>"7"
						],
						[
								"type" => "input",
								"text" => "§l§6|ll| §7몬스터 인식 범위를 적어주세요 (권장값 32) §6|ll|",
								"default"=>"32"
						],
						[
								"type" => "input",
								"text" => "§l§6|ll| §7몬스터 최대 스폰수를 적어주세요  §6|ll|",
						],
						[
								"type" => "input",
								"text" => "§l§6|ll| §7몬스터 너비를 적어주세요  (권장값: 0.9) §6|ll|",
								"default"=>"0.9"
						],
						[
								"type" => "input",
								"text" => "§l§6|ll| §7몬스터 높이를 적어주세요  (권장값: 0.9) §6|ll|",
								"default"=>"0.9"
						],
						[
								"type" => "input",
								"text" => "§l§6|ll| §7몬스터 청소 주기를 적어주세요 (초) §6|ll|",
						],
						[
								"type" => "input",
								"text" => "§l§6|ll| §7몬스터 경험치를 적어주세요 §6|ll|",
						],
						[
								"type" => "input",
								"text" => "§l§6|ll| §7색코드를 지원하는 몬스터의 색코드를 적어주세요 (판다 0~6 | 앵무새 0~4) 만약 없으면 [-1]을 유지해주세요 §6|ll|",
								"default"=> "-1"
						],
				]
		];
		return json_encode($encode);
	}
	
	public function DelUI() {
		$buttons = [];
		foreach ($this->db as $key => $val){
			$array = array("text"=>(string)$key);
			array_push($buttons, $array);
		}
		$this->getdel = $buttons;
		$array = array("text"=>"§l§6|ll| §0메인 §6|ll|");
		array_push($buttons, $array);
		$array = array("text"=>"§l§6|ll| §0나가기 §6|ll|");
		array_push($buttons, $array);
	
		$encode = [
				"type" => "form",
				"title" => "§l§6|ll| §7Dungeon §6|ll|",
				"content" => "§l§6|ll| §7삭제할 몬스터를 선택하십시오 §6|ll|\n\n",
				"buttons" => $buttons,
		];
		return json_encode($encode);
	}
	
	public function ApiUI1() {
	
		$encode = [
				"type" => "form",
				"title" => "§l§6|ll| §7Dungeon API Manager §6|ll|",
				"content" => "§l§6|ll| §7던전 API 매니저에 오신것을 환영합니다! 우선 API 설정에 앞서 몇가지 유의사항을 안내드리겠습니다.§6|ll|\n\n1. API는 던전이 아닌, 사용하시는 레벨에서 관장하는 것이므로 필요한 경우 레벨 플러그인을 수정하셔야 될 수도 있습니다.\n\n2. API 제공 목록: 현재 던전 플러그인은 this->getServer ()->getPluginManager ()->getPlugin ( 플러그인명 ); 을 사용하고 있으며 던전 플러그인은 this->lev->addExp(player, 경험치) 또는 addXp, giveExps로 경험치를 추가하고 있습니다.\n\n3. 사용하시는 레벨플러그인이 위 함수를 지원하는지 여부를 꼭 확인하고 연동시켜주십시오 \n\n4. API초기화를 원하시면 플러그인명에 초기화를 적어주시고 함수명은 아무거나 선택해주십시오",																													
				"buttons" => [
						[
								"text"	 => "§l§6|ll| §0레벨플러그인 이름 입력하기 §6|ll|"
						],
						[
								"text"	 => "§l§6|ll| §0메인 §6|ll|"
						],
						[
								"text"	 => "§l§6|ll| §0나가기 §6|ll|"
						]
				]
				];
		return json_encode($encode);
	}
	
	public function ApiUI2() {
		$encode = [
				"type" => "custom_form",
				"title" => "§l§6|ll| §7Dungeon API Manager §6|ll|",
				"content" => [
						[
								"type" => "input",
								"text" =>  "§l§6|ll| §7플러그인명을 입력해주세요 §6|ll|",
								"default" => "PLevelAPI"
						],
						[
								"type" => "dropdown",
								"text" =>  "§l§6|ll| §7레벨플러그인 EXP 추가 함수를 선택해주세요 §6|ll|",
								"options" => [
										"addExp()",
										"addXp()",
										"giveExps()"
								]
						],
				]
		];
		return json_encode($encode);
	}
	
	public function MessageUI($msg) {
	
		$encode = [
				"type" => "form",
				"title" => "§l§6|ll| §7Dungeon Message §6|ll|",
				"content" => "{$msg}",
				"buttons" => [
						[
								"text"	 => "§l§6|ll| §0메뉴 §6|ll|"
						],
						[
								"text"	 => "§l§6|ll| §0나가기 §6|ll|"
						]
				]
				];
		return json_encode($encode);
	}
	
	public function KillMob($name){
		foreach($this->getServer()->getLevels() as $level){
			foreach($level->getEntities() as $entity){
				if($entity instanceof Base_Entity){
					if($name == $entity->getName()){
						$entity->setLastDamageCause(new EntityDamageEvent($entity, 4, 10000));
						$entity->kill();
						$entity->close();
					}
				}
			}
		}
		$this->db[$name]["monster"] = 0;
		$this->db[$name]["count"] = 0;
	}
	
	public function onCommand(Commandsender $sender, Command $command, string $label, array $args) : bool{
		$name = $sender->getName();
		$cmd = $command->getName();
		if (!$sender instanceof Player) {
			$sender->sendMessage("§c§lProhibited in Console");
			return true;
		}
		if($cmd == "던전"){
			if($sender->isOp()){
				$this->sendUI($sender, 987630, $this->MainUI());
			}
			return true;
		}
		return true;
	}
	/*
	 *  98763 : MessageUI @
	 *  987630 : MainUI @
	 *  987631 : MakeUI @
	 *  987632 : DelUI
	 *  987633 : EditUI1 @
	 *  987634 : PosUI1 @
	 *  987635 : AwardUI 1 @
	 *  987636 : PosUI2 @
	 *  987637 : EditUI2 @
	 *  987638 : AwardUI2 @
	 *  987639 : AwardUI3 @
	 *  987640 : ApiUI1 @
	 *  987641 : ApiUI2 @
	 */
	public function onDataPacketRecieve(DataPacketReceiveEvent $event) {
		$packet = $event->getPacket();
		$player = $event->getPlayer();
		$name = $player->getName();
		$inventory = $player->getInventory();
		if ($packet instanceof ModalFormResponsePacket) {
			$id = $packet->formId;
			$a = json_decode($packet->formData, true);
			if(is_null($a)) return;
			/*
			 *  MainUI
			 */
			if ($id === 987630) {
				if($a === 0){ //생성
					$this->sendUI($player, 987631, $this->MakeUI());
				}
				else if ($a === 1){ //삭제
					$this->sendUI($player, 987632, $this->DelUI());
				}
				else if ($a === 2){ //수정
					$this->sendUI($player, 987633, $this->EditUI1());
				}
				else if ($a === 3){ //위치설정
					$this->sendUI($player, 987634, $this->PosUI1());
				}
				else if ($a === 4){ //보상설정
					$this->sendUI($player, 987635, $this->AwardUI1());
				}
				else if ($a === 5){ //초기화
					foreach ($this->db as $key => $val){
						foreach ($this->getServer()->getLevels() as $level){
							foreach ($level->getEntities() as $entities){
								if($entities instanceof Base_Entity){
									if($entities->getName() == (string)$key){
										$this->KillMob((string)$key);
									}
								}
							}
						}
					}
					$this->sendUI($player, 98763, $this->MessageUI("§l§6|ll| §7초기화가 완료되었습니다. §6|ll|"));
				}
				else if ($a === 6){
					$this->sendUI($player, 987640, $this->ApiUI1());
				}
			}
			/*
			 * MakeUI
			 */
			else if ($id === 987631) {
				if(isset($this->db[$a[1]])){
					$this->sendUI($player, 98763, $this->MessageUI("§l§6|ll| §7이미 존재하는 이름의 몬스터입니다 §6|ll|"));
				}
				else{
					if(!is_null($a)){
						$this->db[$a[1]] = array("id"=>$this->mobs[$a[0]], "health"=>$a[2], "attack"=>$a[3], "size"=>$a[4], "spawn"=>$a[5], "speed"=>$a[6] ,"count"=> 0, "pos"=> [], "clean"=>$a[11], "cleantime"=>0, "item"=>[], "range"=>$a[7], "max"=>$a[8], "monster"=>0, "width"=>$a[9], "height"=>$a[10], "exp"=>$a[12], "color"=>$a[13]);
						$this->sendUI($player, 98763, $this->MessageUI("§l§6|ll| §7설정이 완료되었습니다. §6|ll|"));
					}
				}
			}
			/*
			 * PosUI1
			 */
			else if ($id === 987634) {
				$count = count($this->db);
				if($a === $count){
					$this->sendUI($player, 987630, $this->MainUI());
				}
				else if($a === $count+1){
					return ;		
				}
				else{
					if(!is_null($a)){
						$this->sendUI($player, 987636, $this->PosUI2($this->getposA[$a]["text"]));
						$this->delete[$name] = (string)$this->getposA[$a]["text"];/*
						$ct = 0;
						foreach ($this->db as $key => $val){
							if($ct === $a){
								$this->sendUI($player, 987636, $this->PosUI2($key));
								$this->delete[$name] = (string)$key;
							}
							$ct++;
						}*/
					}
				}
			}
			/*
			 * PosUI2
			 */
			else if ($id === 987636) {
				$count = count($this->db[$this->delete[$name]]["pos"]);
				if($a === $count+1){
					$this->sendUI($player, 987630, $this->MainUI());
					//unset($this->delete[$name]);
				}
				else if($a === $count+2){
					//unset($this->delete[$name]);
					return ;
				}
				else if ($a === $count){
					$this->sendUI($player, 98763, $this->MessageUI("§l§6|ll| §7현재 좌표를 스폰 위치로 추가하였습니다. §6|ll|"));
					$array = array("x"=>$player->getX(), "y"=>$player->getY(),"z"=>$player->getZ(), "lev"=>$player->getLevel()->getFolderName());
					array_push($this->db[$this->delete[$name]]["pos"], $array);
					//unset($this->delete[$name]);
				}
				else{
					if(!is_null($a)){
						$this->sendUI($player, 98763, $this->MessageUI("§l§6|ll| §7삭제가 완료되었습니다. §6|ll|"));
						unset($this->db[$this->delete[$name]]["pos"][(int)$this->getposB[$a]]);
						$this->KillMob($this->delete[$name]);
					}
				}
			}
			/*
			 * EditUI1
			 */
			else if ($id === 987633) {
				$count = count($this->db);
				if($a === $count){
					$this->sendUI($player, 987630, $this->MainUI());
				}
				else if($a === $count+1){
					return ;
				}
				else{
					if(!is_null($a)){
						$this->sendUI($player, 987637, $this->EditUI2($this->getedit[$a]["text"]));
						$this->edit[$name] = (string)$this->getedit[$a]["text"];/*
						$ct = 0;
						foreach ($this->db as $key => $val){
							
							
							if($ct === $a){
								$this->sendUI($player, 987637, $this->EditUI2($key));
								$this->edit[$name] = (string)$key;
							}
							$ct++;
						}*/
					}
				}
			}
			/*
			 * EditUI2
			 */
			else if ($id === 987637) {
				if(!is_null($a[0])){
					$this->KillMob($this->edit[$name]);
					$pos = $this->db[$this->edit[$name]]["pos"];
					$it = $this->db[$this->edit[$name]]["item"];
					unset($this->db[$this->edit[$name]]);
					$this->db[$a[1]] = array("id"=>$a[0], "health"=>$a[2], "attack"=>$a[3], "size"=>$a[4], "spawn"=>$a[5], "speed"=>$a[6],"count"=> 0, "pos"=> $pos, "clean"=>$a[11], "cleantime"=>0, "item"=>$it, "range"=>$a[7], "max"=>$a[8], "monster"=>0, "width"=>$a[9], "height"=>$a[10], "exp"=>$a[12], "color"=>$a[13]);
					$this->sendUI($player, 98763, $this->MessageUI("§l§6|ll| §7수정이 완료되었습니다. 다음 스폰부터 적용됩니다. §6|ll|"));
				}
			}
			/*
			 * AwardUI1
			 */
			else if ($id === 987635) {
				$count = count($this->db);
				if($a === $count){
					$this->sendUI($player, 987630, $this->MainUI());
				}
				else if($a === $count+1){
					return ;
				}
				else{
					if(!is_null($a)){
						$this->sendUI($player, 987638, $this->AwardUI2($this->getawardA[$a]["text"]));
						$this->award[$name] = (string)$this->getawardA[$a]["text"];/*
						$ct = 0;
						foreach ($this->db as $key => $val){
							if($ct === $a){
								$this->sendUI($player, 987638, $this->AwardUI2($key));
								$this->award[$name] = (string)$key;
							}
							$ct++;
						}*/
					}
				}
			}
			/*
			 * AwardUI2
			 */
			else if ($id === 987638) {
				$count = count($this->db[$this->award[$name]]["item"]);
				if($a === $count+1){
					$this->sendUI($player, 987630, $this->MainUI());
					//unset($this->delete[$name]);
				}
				else if($a === $count+2){
					//unset($this->delete[$name]);
					return ;
				}
				else if ($a === $count){
					$this->sendUI($player, 987639, $this->AwardUI3());
					//unset($this->delete[$name]);
				}
				else{
					if(!is_null($a)){
						$this->sendUI($player, 98763, $this->MessageUI("§l§6|ll| §7삭제가 완료되었습니다. §6|ll|"));
						unset($this->db[$this->award[$name]]["item"][$this->getawardB[$a]]);
					}
				}
			}
			/*
			 * AwardUI3
			 */
			else if ($id === 987639) {
				if($a[0] !== ""){
					if(!is_null($a)){
					$item = $player->getInventory()->getItemInHand();
					$array = array("nbt"=>$item->jsonSerialize(), "prob"=>$a[0]);
					array_push($this->db[$this->award[$name]]["item"], $array);
					$this->sendUI($player, 98763, $this->MessageUI("§l§6|ll| §7손에 들고있는 아이템이 보상으로 추가되었습니다. §6|ll|"));
					}
				}
			}
			/*
			 * DelUI
			 */
			else if ($id === 987632) {
				$count = count($this->db);
				if($a === $count){
					$this->sendUI($player, 987630, $this->MainUI());
				}
				else if($a === $count+1){
					return ;
				}
				else{
					if(!is_null($a)){
						$this->sendUI($player, 98763, $this->MessageUI("§l§6|ll| §7성공적으로 삭제되었습니다. §6|ll|"));
						$this->KillMob($this->getdel[$a]["text"]);
						unset($this->db[$this->getdel[$a]["text"]]);
						/*
						$ct = 0;
						foreach ($this->db as $key => $val){
							if($ct === $a){
								$this->sendUI($player, 98763, $this->MessageUI("§l§6|ll| §7성공적으로 삭제되었습니다. §6|ll|"));
								foreach ($this->getServer()->getLevels() as $level){
									foreach ($level->getEntities() as $entities){
										if($entities instanceof Base_Entity){
											if($entities->getName() == (string)$key){
												$entities->setLastDamageCause(new EntityDamageEvent($entities, 4, 1000));
												$entities->kill();
												$entities->close();
											}
										}
									}
								}
								unset($this->db[$key]);
							}
							$ct++;
						}*/
					}
				}
			}
			/*
			 * ApiUI1
			 */
			else if ($id === 987640) {
				if ($a === 0){
					$this->sendUI($player, 987641, $this->ApiUI2());
				}
				else if ($a === 1){
					$this->sendUI($player, 987630, $this->MainUI());
				}
				else if ($a === 2){
					return ;
				}
			}
			/*
			 * ApiUI2
			 */
			else if ($id === 987641) {
				if(!is_null($a)){
					if($a[0] == "초기화"){
						$this->api[0] = 1;
						unset($this->api[1]);
						$this->sendUI($player, 98763, $this->MessageUI("§l§6|ll| §7초기화가 완료되었습니다 §6|ll|"));
					}
					else if($this->getServer ()->getPluginManager ()->getPlugin ( $a[0]) != null){
						$this->api[0] = $a[0];
						$this->api[1] = $a[1];
						$this->sendUI($player, 98763, $this->MessageUI("§l§6|ll| §7성공적으로 설정 되었습니다. §6|ll|"));
					}
					else{
						$this->sendUI($player, 98763, $this->MessageUI("§l§6|ll| §7존재하지 않는 api입니다 §6|ll|"));
					}
				}
			}
			/*
			 * MessageUI
			 */
			else if ($id === 98763) {
				if($a === 0){ //생성
				//var_dump($this->db);
					$this->sendUI($player, 987630, $this->MainUI());
				}
				else if ($a === 1){ //삭제
					return ;
				}
			}
		}
	}
	
	public function Count(string $name){
		$count = 0;
		foreach($this->getServer()->getLevels() as $level){
			foreach($level->getEntities() as $entity){
				if($entity instanceof Base_Entity){
					if($entity->getName() == $name){
						$count++;
					}
				}
			}
		}
		return $count;
	}
	
	public function SpawnMobs($x, $y, $z, $lev, $id, $nm, $ht, $dam, $size, $speed, $range, $width, $height, $key){
		$nbt = new CompoundTag("", [
				new ListTag("Pos", [
						new DoubleTag("", $x),
						new DoubleTag("", $y),
						new DoubleTag("", $z)
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
		$level = $this->getServer()->getLevelByName($lev);
		$this->width = $width;
		$this->height = $height;
		$entity = Entity::createEntity($id, $this->getServer()->getLevelByName($lev), $nbt);
		if(is_null($entity)){
			unset($this->db[$key]);
			$this->getServer()->broadcastMessage("§c[WARNING] Undefined Monster Name {$id}");
			$this->getServer()->broadcastMessage("§3[SERVER] Backtracing... Please wait 1~2 seconds");
			sleep(1);
			$this->getServer()->broadcastMessage("§3[SERVER] Complete! Killed {$id}");
			$this->getLogger()->alert(TextFormat::RED."Undefined Monster Name {$id}");
			return 333;
		}
		$entity->setName($nm);
		$entity->setNameTag($nm."\n§c§l♡{$ht} 📕📕📕📕📕📕📕📕📕📕");
		//$entity->setNameTag($nm);
		$entity->setNameTagAlwaysVisible(true);
		$entity->setMaxHealth($ht);
		$entity->setHealth($ht);
		$entity->setDamage((float)$dam);
		$entity->setScale((float)$size);
		$entity->setSpeed($speed);
		$entity->setDistance($speed);
		$this->propertyManager = $entity->getDataPropertyManager();
		$this->propertyManager->setFloat($entity::DATA_BOUNDING_BOX_WIDTH, (float)$this->width);
		$this->propertyManager->setFloat($entity::DATA_BOUNDING_BOX_HEIGHT, (float)$this->height);
		$entity->setKeys(2);
		if(!isset($this->db[$key]["color"]))$this->db[$key]["color"] = -1;
		if($this->db[$key]["color"] != -1 || $id != "Horse_entity" || $id != "Sheep_entity"){
			$entity->setColor($this->db[$key]["color"]);
		}
		$entity->spawnToAll();
		return 111;
	}
	
	public function Reset($entities){
		$type = "";
		foreach($this->mobs as $key => $val){
			if($entities instanceof $val){
				$type = $val;
				break;
			}
		}
		foreach($this->getServer()->getLevels() as $level){
			foreach($level->getEntities() as $entity){
				if($entity instanceof Base_Entity){
					if($entity instanceof $type){
						$entity->kill();
						$entity->close();
					}
				}
			}
		}
		foreach ($this->db as $key => $val){
			if($val["id"] == $type){
				$this->db[$key]["monster"] = 0;
			$this->db[$key]["count"] = 0;
			$this->db[$key]["cleantime"] = 0;
			}
		}
	}
	
	public function CountMobs($name){
		$count = 0;
		foreach ($this->getServer()->getLevels() as $level){
		foreach($level->getEntities() as $entity){
			if($entity instanceof Base_Entity){
				if($entity->getName() == $name){
					$count++;
				}
			}
		}
		}
		return $count;
	}
	
}

class TTask extends Task{
	private $owner;
	public function __construct(Main $owner){
		$this->owner = $owner;
	}
	public function onRun( $currentTick ) {
		/*
		 *  Dungeon Clean Source
		 */
		//var_dump($this->owner->db)
		foreach ($this->owner->db as $key => $val){
			foreach($val["pos"] as $key2 => $val2){
				$this->owner->getServer()->loadLevel($val2["lev"]);
				//$this->owner->getServer()->broadcastMessage ($val2["lev"]." 로드 완료");
			}
		}
		foreach ($this->owner->db as $key => $val){
			if((string)$key == "mobs") continue;
			if(!isset($val["cleantime"])){
				//$this->owner->db[$key]["cleantime"] = 0;
				$this->owner->getServer()->broadcastMessage("§cl§l[WARNING] 클린시간 오류. /던전을 쳐 수정 후 사용해주세요");
				continue;
			}
			if(!isset($val["clean"])){
				//$this->owner->db[$key]["clean"] = 10;
				$this->owner->getServer()->broadcastMessage("§cl§l[WARNING] 클린 초기화 시간 오류. /던전을 쳐 수정 후 사용해주세요");
				continue;
			}
			if($val["cleantime"] == $val["clean"]){
				foreach ($this->owner->getServer()->getLevels() as $level){
					foreach ($level->getEntities() as $entities){
						if($entities instanceof Base_Entity){
							if($entities->getName() == (string)$key){
								$this->owner->KillMob((string)$key);
								//$this->owner->getServer()->broadcastMessage("hdjdhdjdh");
							}//name
						}//base
					}//entity
				}//level
				$this->owner->db[$key]["cleantime"] = 0;
				$this->owner->db[$key]["monster"]=0;
			}//cleantime
			else{
				$this->owner->db[$key]["cleantime"]++;
			}//nocleantime
		}
			/*
			 * Spawn Source
			 */
		foreach($this->owner->db as $key => $val){
			if((string)$key == "mobs") continue;
			if(!isset($val["count"])){
				//$this->owner->db[$key]["count"] = 0;
				$this->owner->getServer()->broadcastMessage("§cl§l[WARNING] 스폰시간 오류. /던전을 쳐 수정 후 사용해주세요");
				continue;
			}
			if(!isset($val["spawn"])){
				//$this->owner->db[$key]["spawn"] = 3;
				$this->owner->getServer()->broadcastMessage("§cl§l[WARNING] 스폰 오류. /던전을 쳐 수정 후 사용해주세요");
				continue;
			}
			//var_dump($this->owner->db);
			if($val["count"] == $val["spawn"]){
					$id = $val["id"];
					$this->owner->db[$key]["count"] = 0;
					foreach ($val["pos"] as $key2 => $val2){
						if($this->owner->CountMobs((string)$key) < (int)$val["max"] && isset($val["pos"][0])){
						$x = $val2["x"];
						$y = $val2["y"];
						$z = $val2["z"];
						$lev = $val2["lev"];
						$code = $this->owner->SpawnMobs($x, $y, $z, $lev, $id, (string)$key, $val["health"], $val["attack"], $val["size"], (int)$val["speed"], (int)$val["range"], (float)$val["width"], (float)$val["height"], (string)$key);
						
						if($code == 333){
							break;
						}//code
					}//monster
				}//forpos
			}//count
			else{
				$this->owner->db[$key]["count"]++;
			}//count
		}
	}
}
