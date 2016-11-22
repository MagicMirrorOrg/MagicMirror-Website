'use strict'

const path = require('path')

module.exports = {
  module: {
    loaders: [
      {
        test: /\.json$/,
        loader: 'json-loader'
      },
    ]
  }
}