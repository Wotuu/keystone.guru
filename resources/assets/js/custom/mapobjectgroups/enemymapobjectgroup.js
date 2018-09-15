class EnemyMapObjectGroup extends MapObjectGroup {
    constructor(map, name, classname, editable) {
        super(map, name, editable);

        this.classname = classname;
        this.title = 'Hide/show enemies';
        this.fa_class = 'fa-users';
    }

    _createObject(layer) {
        console.assert(this instanceof EnemyMapObjectGroup, 'this is not an EnemyMapObjectGroup');

        switch (this.classname) {
            case "AdminEnemy":
                return new AdminEnemy(this.map, layer);
            default:
                return new Enemy(this.map, layer);
        }
    }

    fetchFromServer(floor, callback) {
        // no super call required
        console.assert(this instanceof EnemyMapObjectGroup, this, 'this is not a EnemyMapObjectGroup');

        let self = this;

        $.ajax({
            type: 'GET',
            url: '/ajax/enemies',
            dataType: 'json',
            data: {
                floor_id: floor.id
            },
            success: function (json) {
                // Now draw the enemies on the map
                for (let index in json) {
                    if (json.hasOwnProperty(index)) {
                        let remoteEnemy = json[index];

                        // If the map isn't teeming, but the enemy is teeming..
                        if (!self.map.teeming && remoteEnemy.teeming === 'visible') {
                            console.log('Skipping teeming enemy ' + remoteEnemy.id);
                            continue;
                        }
                        // If the map is teeming, but the enemy shouldn't be there for teeming maps..
                        else if (self.map.teeming && remoteEnemy.teeming === 'invisible') {
                            console.log('Skipping teeming-filtered enemy ' + remoteEnemy.id);
                            continue;
                        }

                        let layer = new LeafletEnemyMarker();
                        layer.setLatLng(L.latLng(remoteEnemy.lat, remoteEnemy.lng));

                        let enemy = self.createNew(layer);
                        enemy.id = remoteEnemy.id;
                        enemy.enemy_pack_id = remoteEnemy.enemy_pack_id;
                        enemy.floor_id = remoteEnemy.floor_id;
                        enemy.teeming = remoteEnemy.teeming;
                        enemy.faction = remoteEnemy.faction;
                        enemy.enemy_forces_override = remoteEnemy.enemy_forces_override;

                        enemy.setNpc(remoteEnemy.npc);

                        // Is probably null if there's no patrol set
                        if (remoteEnemy.patrol !== null) {

                        }

                        // We just downloaded the enemy pack, it's synced alright!
                        enemy.setSynced(true);
                    }
                }

                callback();
            }
        });
    }
}