import { ActionTypes } from "./Types";
import { initialData } from "./initialData";

/**
 * Data store reducer
 *
 * Store current content of data store and action object.
 * Use them to make changes in data store.
 *
 * Create and return new object containing all necessary changes.
 * If data type is not recognized, reducer return unchanged data store object.
 */
export const Reducer = (storeData, action) => {
  switch(action.type) {
    case ActionTypes.STORE:
      return {
        ...storeData,
        [action.dataType]: storeData[action.dataType].concat([action.payload])
      }
    case ActionTypes.UPDATE:
      return {
        ...storeData,
        [action.dataType]: storeData[action.dataType].map(p =>
          p['@id'] === action.payload['@id'] ? action.payload : p)
      }
    case ActionTypes.DELETE:
      return {
        ...storeData,
        [action.dataType]: storeData[action.dataType].filter(p =>
          p['@id'] !== action.payload['@id'])
      };
    default:
      return storeData || initialData.modelData;
  }
//
}
