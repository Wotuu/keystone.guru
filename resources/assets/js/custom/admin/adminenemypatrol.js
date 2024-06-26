class AdminEnemyPatrol extends EnemyPatrol {

    constructor(map, layer) {
        super(map, layer);

        this.setSynced(false);

        // Container
        this.enemyConnectionsLayerGroup = null;
        // Layer to has all polylines for the connected enemies to this patrol
        this.connectedEnemiesLayer = null;

        getState().register('floorid:changed', this, this.redrawConnectionsToEnemies.bind(this));
        this.map.register('map:mapstatechanged', this, this._mapStateChangedEvent.bind(this));
    }

    /**
     * Called when enemy selection for this enemy has changed (started/finished)
     * @private
     */
    _mapStateChangedEvent() {
        this.redrawConnectionsToEnemies();
    }

    /**
     *
     * @returns {*[]}
     * @private
     */
    _getVisibleEnemiesLatLngs() {
        console.assert(this instanceof EnemyPatrol, 'this was not an EnemyPatrol', this);

        let result = [];
        for (let index in this.enemies) {
            let enemyCandidate = this.enemies[index];

            if (enemyCandidate.shouldBeVisible()) {
                result.push(enemyCandidate.layer.getLatLng());
            }
        }

        return result;
    }

    /**
     * Must be explicitly overriden since EnemyPatrols cannot be deleted; admin ones can.
     * @returns {boolean}
     */
    isEditable() {
        return true;
    }

    /**
     * @param {Enemy} enemy
     */
    addEnemy(enemy) {
        super.addEnemy(enemy);

        enemy.register('object:changed', this, this.redrawConnectionsToEnemies.bind(this));
    }

    /**
     * @param {Enemy} enemy
     */
    removeEnemy(enemy) {
        super.removeEnemy(enemy);

        enemy.unregister('object:changed', this);
    }

    /**
     * Removes any existing UI connections to enemies.
     */
    removeExistingConnectionsToEnemies() {
        console.assert(this instanceof EnemyPatrol, 'this is not an EnemyPatrol', this);

        // Remove previous layers if it's needed
        if (this.enemyConnectionsLayerGroup !== null) {
            let enemyPatrolMapObjectGroup = this.map.mapObjectGroupManager.getByName(MAP_OBJECT_GROUP_ENEMY_PATROL);
            // Remove layers we no longer need from the layer group
            if (this.connectedEnemiesLayer !== null) {
                this.enemyConnectionsLayerGroup.removeLayer(this.connectedEnemiesLayer);
                this.connectedEnemiesLayer = null;
            }
            // And finally remove the layer group from the KZ layer group
            enemyPatrolMapObjectGroup.layerGroup.removeLayer(this.enemyConnectionsLayerGroup);

            this.enemyConnectionsLayerGroup = null;
        }
    }

    /**
     *
     */
    redrawConnectionsToEnemies() {
        console.assert(this instanceof EnemyPatrol, 'this is not an EnemyPatrol', this);

        this.removeExistingConnectionsToEnemies();

        // If the patrol is not visible, don't draw any new stuff
        if (!this.shouldBeVisible()) {
            return;
        }

        this.enemyConnectionsLayerGroup = new L.LayerGroup();

        let enemyPatrolMapObjectGroup = this.map.mapObjectGroupManager.getByName(MAP_OBJECT_GROUP_ENEMY_PATROL);
        enemyPatrolMapObjectGroup.layerGroup.addLayer(this.enemyConnectionsLayerGroup);

        // Add connections from each enemy to our location
        let enemyLatLngs = this._getVisibleEnemiesLatLngs();

        if (enemyLatLngs.length > 0) {
            this.centerLatLng = this.getLayerLatLng();
            this.connectedEnemiesLayer = new L.LayerGroup();

            for (let index in enemyLatLngs) {
                if (enemyLatLngs.hasOwnProperty(index)) {
                    let coupledEnemyLatLng = enemyLatLngs[index];

                    this.connectedEnemiesLayer.addLayer(
                        L.polyline([
                            [this.centerLatLng.lat, this.centerLatLng.lng],
                            coupledEnemyLatLng
                        ], c.map.adminenemypatrol.polylineOptions)
                    );
                }
            }

            // do not prevent clicking on anything else
            this.enemyConnectionsLayerGroup.setZIndex(-1000);

            this.enemyConnectionsLayerGroup.addLayer(this.connectedEnemiesLayer);
        }
    }

    localDelete(massDelete = false) {
        super.localDelete(massDelete);

        // Add all the enemies in said pack to the toggle display
        let enemyMapObjectGroup = this.map.mapObjectGroupManager.getByName(MAP_OBJECT_GROUP_ENEMY);

        for (let key in enemyMapObjectGroup.objects) {
            let enemy = enemyMapObjectGroup.objects[key];

            // Detach all enemies from this patrol if it's deleted
            if (enemy.enemy_patrol_id === this.id) {
                enemy.setEnemyPatrol(null);
                enemy.save();
            }
        }

        this.removeExistingConnectionsToEnemies();
    }

    cleanup() {
        super.cleanup();

        getState().unregister('floorid:changed', this);
        this.map.unregister('map:mapstatechanged', this);
    }
}
