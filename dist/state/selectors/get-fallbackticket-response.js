'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _get = require('lodash/get');

var _get2 = _interopRequireDefault(_get);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

/**
 * Gets the fallback ticket response
 * @param {Object} state - global redux state
 * @return {String} current state value
 */
exports.default = function (state) {
  return (0, _get2.default)(state, 'fallbackTicket.response');
}; /** @format */

/**
 * External dependencies
 */