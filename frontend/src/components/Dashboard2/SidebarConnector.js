import { connect } from "react-redux";
import { withRouter } from "react-router-dom";

import { DataTypes } from "../../data/Types";
import { DataGetter } from "../../data/DataGetter";
import { getData } from "../../data/ActionCreators";
import SidebarDisplay from "./SidebarDisplay";

export default function SidebarConnector() {
  const mapStateToProps = (storeData) => ({
    categories: storeData.modelData[DataTypes.CATEGORIES],
  })

  const mapDispatchToProps = (dispatch, ownProps) => ({
    getData: (type) => dispatch(getData(type))
  })

  return withRouter(connect(mapStateToProps, mapDispatchToProps)(
    DataGetter(DataTypes.CATEGORIES, SidebarDisplay)))
}
