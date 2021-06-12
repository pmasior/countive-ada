import { ActionTypes } from "./Types";

export const getData = (dataType) => ({
  type: ActionTypes.GET_DATA,
  dataType: dataType
})

export const deleteData = (dataType, payload) => ({
  type: ActionTypes.DELETE,
  dataType: dataType,
  payload: payload  // cały obiekt
});

export const saveData = (dataType, payload) => {
  // alert(`saveData: ${JSON.stringify(dataType, null, 2)}`);  // TODO: delete alert
  if (payload['@id']) {
    return {
      type: ActionTypes.UPDATE,
      dataType: dataType,
      payload: payload
    }
  } else {
    return {
      type: ActionTypes.STORE,
      dataType: dataType,
      payload: payload
    }
  }

};

