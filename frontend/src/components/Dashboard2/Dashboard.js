import React from "react";
import SidebarConnector from "./SidebarConnector";
import SubcategoryConnector from "./SubcategoryConnector";
import TransactionsConnector from "./TransactionsConnector";
import {EditorConnector} from "./EditorConnector";
import {DataTypes} from "../../data/Types";
import TransactionEditor from "./TransactionEditor";
import Navbar from "./Navbar";

const ConnectedSidebar = SidebarConnector();
const ConnectedSubcategory = SubcategoryConnector();
const ConnectedTransactions = TransactionsConnector();
const ConnectedTransactionEditor = EditorConnector(DataTypes.TRANSACTIONS, TransactionEditor)

export const Dashboard =
  (props) => {
    const modeParam = props.match.params.mode;

    return (
      <div>
        <header className="navbar bg-light sticky-top flex-md-nowrap shadow-sm justify-content-start">
          <Navbar />
        </header>
        <div className="container-fluid">
          <div className="row">
            <nav className="col-md-2 col-lg-2 d-md-block bg-light sidebar collapse shadow-sm
                            position-fixed top-0 mt-5 p-2 h-auto" style={{'zIndex': '100'}}
                 id="sidebarMenu">
              <div className="d-none d-md-block vh-100 float-start"/>
              <ConnectedSidebar />
            </nav>
            <main className="col-md-10 ms-md-auto d-md-flex">
              <div className="p-3" style={{'flex-basis': '30rem'}}>
                <ConnectedSubcategory />
              </div>
              <div className="flex-grow-1 p-3">
                <ConnectedTransactions />
              </div>
            </main>
          </div>
        </div>
        {(modeParam === "edit") &&
          <ConnectedTransactionEditor headerTitle="Edit transaction"/>
        }
        {(modeParam === "create") &&
          <ConnectedTransactionEditor headerTitle="Add transaction"/>
        }
      </div>
    );
  }
