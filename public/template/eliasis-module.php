<?php
/**
 * PHP library for adding addition of modules for Eliasis Framework.
 *
 * @author     Josantonius - hello@josantonius.com
 * @copyright  Copyright (c) 2017
 * @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link       https://github.com/Eliasis-Framework/Module
 * @since      1.0.8
 */

use Eliasis\View\View;

$data = View::get();
?>
<div id="eliasis-modules">

    <transition-group name="list" tag="div">
        <div v-for="error in errors" v-bind:key="error">
            <div class="jst-install-error">
                <p><strong>
                    <span class="jst-error-msg">{{ error.message }}</span>
                </strong></p>
            </div>
        </div>
    </transition-group>

    <div class="mdl-cell mdl-cell--12-col mdl-grid mdl-grid--no-spacing-off">
        <div v-for="(module, key) in modules" class="eliasis-module mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col-tablet mdl-cell--12-col-phone ">
            <div class="mdl-card__title mdl-card--expand mdl-color--blue-200" :style="module.image_style">
                <a :href="module.uri" title="" target="_blank">
                    <transition name="component-fade" mode="out-in">
                        <div class="module-version" v-bind:key="module.version">
                            {{ module.version }}
                        </div>
                    </transition>
                </a>
            </div>
            <div class="jst-card--border"></div>
            <div class="mdl-card__supporting-text mdl-color-text--grey-600">
            
                <h2 class="mdl-card__title-text card-title">
                    {{ module.name }}
                </h2>
            </transition>
                <br>
                {{ module.description }}
                <div class="mdl-list__item">
                   <div class="custom-fields">
                        <div class="module-state-btn">
                            <state-buttons :module-id="module.id" :module-state='module.state' :module-version='module.version' v-model="module.version" v-model="errors" inline-template>
                                <div class="state-buttons">
                                    <transition name="fade" mode="out-in">
                                        <button v-bind:class="['mdl-button', 'mdl-js-button', 'mdl-button--raised', 'mdl-js-ripple-effect', 'mdl-button--accent', 'mod-btn', 'module-btn', 'module-btn-left', { 'module-btn-active': isActive, 'module-btn-outdated': isOutdated, 'module-btn-uninstalled': isUninstalled }]" v-on:click="changeState()" :disabled="isUninstall || isInstall">
                                            <span class="module-load module-open module-load-install" v-if="isInstall"></span>
                                            {{ isInstall ? '' : changeButtonState }}
                                        </button>
                                    </transition>
                                    <transition name="fade" mode="out-in">
                                        <button class=" mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mod-btn mdl-button--accent module-btn module-btn-uninstall" v-if="isInactive" v-on:click="uninstall()" :disabled="isUninstall">
                                            <span class="module-load module-open module-load-remove" v-if="isUninstall"></span>
                                            {{ isUninstall ? '' : removeButton }}
                                        </button>
                                    </transition>
                                </div>
                            </state-buttons>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id='modules-filter'
         data-app='<?= $data["app"] ?>'
         data-sort='<?= $data["sort"] ?>'
         data-filter='<?= $data["filter"] ?>' 
         data-external='<?= $data["external"] ?>'>
    </div>

</div>