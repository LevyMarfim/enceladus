import { startStimulusApp } from '@symfony/stimulus-bundle';

const app = startStimulusApp();
// register any custom, 3rd party controllers here
// app.register('some_controller_name', SomeImportedController);

import { Application } from '@hotwired/stimulus';
import DatepickerController from './controllers/datepicker_controller.js';

// const application = Application.start();
app.register('datepicker', DatepickerController);

import TickerValidationController from './controllers/ticker_validation_controller.js';

// const application = Application.start();
app.register('ticker-validation', TickerValidationController);

import CnpjController from './controllers/cnpj_controller.js';
app.register('cnpj-mask', CnpjController);

import CollectionController from './controllers/collection_controller.js';
app.register('collection', CollectionController);