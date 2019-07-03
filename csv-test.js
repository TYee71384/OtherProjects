const createCsvWriter = require('csv-writer').createObjectCsvWriter;
const htmlencode = require('htmlencode').htmlEncode;
const csvWriter = createCsvWriter({
  path: 'out.csv',
  //header
  header: [
      { id: 'id', title: 'IDissue' },
      { id: 'title', title: 'Title'},
      { id: 'status', title: 'Status'},
      { id: 'category', title: 'Category'},
      { id: 'type', title: 'Type'},
      { id: 'description', title: 'Description' },
      { id: 'analysis', title: 'Analysis'},
      { id: 'conversion', title: 'ConversionDesc'},
      { id: 'origin', title: 'Origin'},
      { id: 'synopsis', title: 'Synopsis'},
      { id: 'currentSetup', title: 'CurrentSetup'},
      { id: 'assigned', title: 'Assigned' },
      { id: 'reviewer', title: 'Reviewer' },
      { id: 'facilitator', title: 'Facilitator'},
      { id: 'reportedDate', title: 'ReportedDate'},
  ]
});

//setup connection
const knex = require('knex')({
  client: 'mssql',
  connection: {
    host: '172.25.0.226',
    user: 'CAPA_webuser',
    password: 'CaPa',
    database: 'CAPA'
  }
});

let objectArray = [];

checkForNulls = (item) => {
    for(let i in item)
    {
        if(item[i] === null)
        item[i] = '';
        
    }
}

knex.select().from('LogIssue').orderBy('IDissue', 'desc').where('Status','Complete')
//.andWhere('IDissue', '<', 283)
.andWhereNot('IDissue', 364)
.andWhereNot('IDissue', 362)
.andWhereNot('IDissue', 350)
.andWhereNot('IDissue', 338)



//.limit(10)

//381-366

//corrupt 364

  .then(async (rows) => {
    for (let item of rows) {
        checkForNulls(item);    

      id = item.IDissue;
      title = item.GenInfoTitle;
      status = item.Status;
      category = item.GenInfoCategory;
      type = item.GenInfoType;
      item.GenInfoDescription !== '' ? description = htmlencode(item.GenInfoDescription) : '';
     analysis = item.RcaAnalysis;
      conversion = `<b>GENERAL INFORMATION</b><br><br><br>`
      conversion += `<b>CAPA ID#:</b> ${item.IDissue}<br><br>`;
      conversion += `<b>Entered By:</b> ${item.GenInfoEnteredBy} @ ${item.GenInfoEnteredTime}<br><br>`;
      conversion += `<b>Last Edit By:</b> ${item.GenInfoEditBy} @ ${item.GenInfoEditTime}<br><br>`;
      conversion += `<b>Source:</b> ${item.GenInfoSource}<br><br>`;
      conversion += `<b>Category:</b> ${item.GenInfoCategory}<br><br>`;
      conversion += `<b>Scope:</b> ${item.GenInfoScope}<br><br>`;
      //  conversion += `"<b>Responsible:</b> ${item.GenInfoSource}<br><br>`;


      await knex.select().from('LogIssueResponsible').where('IDissue', item.IDissue)
        .then((rows) => {
          let responsibleString = '';
          if (rows.length > 0) {
            responsibleString = '<b>Responsible:</b> ';
            let comma = '';
            for (let x of rows) {
              responsibleString += `${comma}${x.GenInfoResponsible}`;
              comma = ', ';
            }
          }
          responsibleString !== '' ? conversion += `${responsibleString}<br><br>` : conversion += '';
        });

      conversion += `<b>Risk Evaluation:</b> ${item.GenInfoRisk.replace(/"/g,"'")}<br><br>`;
      conversion += `<b>MDR #:</b> <a href="${item.MdrLink}">${item.MdrNumber}</a><br><br>`;
      conversion += `<b>MDR Due Date:</b> ${item.MdrDueDate}<br><br>`;
      conversion += `<b>Correction Report #:</b> <a href="${item.CorrectionReportLink}">${item.CorrectionReportNumber}</a><br><br>`;
      conversion += `<b>Correction Report Due Date:</b> ${item.CorrectionReporDueDate}<br><br>`;

      //  Associated Audit Findings

      // Related CAPAs
      await knex.select().from('LogIssueRelated').where('IDissue', item.IDissue)
        .then((rows) => {
          let relatedString = '';
          if (rows.length > 0) {
            relatedString = '<b>Related CAPA Issues:</b> ';
            let comma = '';
            for (let x of rows) {
              relatedString += `${comma}<a href="http://magicweb/CAPA/IssueDisplay.asp?ID=${x.IDrelated}">${x.IDrelated}</a>`;
              comma = ', ';
            }
          }
          relatedString !== '' ? conversion += `${relatedString}<br><br>` : conversion += '';
        });

      origin = `<b>APPRAISAL SUMMARY</b><br><br><br>`;
      item.ApprovalFiledBy ? origin += `<b>Filed By:</b> ${item.AppraisalFiledBy} @ ${item.AppraisalFiledTime}<br><br>` : '';
      item.AppraisalResearch !== '' ? origin += `<b>Research Notes:</b> ${item.AppraisalResearch.replace(/"/g,"'")}<br><br>` : origin += '';
      item.AppraisalImpact !== '' ? origin += `<b>Is there impact and risk to the overall quality system?</b> ${item.AppraisalImpact.replace(/"/g,"'")}<br><br>` : origin += '';
      item.AppraisalAction !== '' ? origin += `<b>What immediate or remedial action was taken?</b> ${item.AppraisalAction.replace(/"/g,"'")}<br><br>` : origin += '';
      item.AppraisalResolve !== '' ? origin += `<b>Did the action resolve the issue?</b> ${item.AppraisalResolve.replace(/"/g,"'")}<br><br>` : origin += '';
      item.AppraisalOther !== '' ? origin += `<b>What, if any, other action will be taken?</b> ${item.AppraisalOther.replace(/"/g,"'")}<br><br>` : origin += '';
      origin += `<br><b>ROOT CAUSE ANALYSIS</b><br><br><br>`;
      item.RcaFiledBy ? origin += `<b>Filed By:</b> ${item.RcaFiledBy} @ ${item.RcaFiledTime}<br><br>` : '';
      item.RcaScope !== '' ? origin += `<b>Scope:</b> ${item.RcaScope.replace(/"/g,"'")}<br><br>` : origin += '';
      item.RcaSummary !== '' ? origin += `<b>Historical Summary:</b> ${item.RcaSummary.replace(/"/g,"'")}<br><br>` : origin += '';
      item.RcaCause !== '' ? origin += `<b>Cause of Issue:</b> ${item.RcaCause.replace(/"/g,"'")}<br><br>` : origin += '';
      item.RcaDocumentation !== '' ? origin += `<b>Documentation:</b> ${item.RcaDocumentation.replace(/"/g,"'")}<br><br>` : origin += '';

      await knex.select().from('LogIssueRcaStaff').where('IDissue', item.IDissue)
        .then((rows) => {
          let relatedString = '';
          if (rows.length > 0) {
            relatedString = '<b>Staff:</b> ';
            let comma = '';
            for (let x of rows) {
              relatedString += `${comma}${x.RcaStaff}`;
              comma = ', ';
            }
          }
          relatedString !== '' ? origin += `${relatedString}<br><br>,` : origin += ',';
        });

      item.OverrideDetails !== '' ? origin += `<b>Supporting Details:</b> ${item.OverrideDetails.replace(/"/g,"'")}<br><br>` : origin += '';
      origin += `<br><b>ROOT CAUSES</b><br><br><br>`;
      origin += `<b>Filed By:</b> ${item.RcaConclusionFiledBy} @ ${item.RcaConclusionFiledTime}<br><br>`;

      await knex.select().from('LogIssueRcaCategory').where('IDissue', item.IDissue)
        .then((rows) => {
          let relatedString = '';
          if (rows.length > 0) {
            relatedString = '<b>Cause Category : Root Cause</b>';
            for (let x of rows) {
              relatedString += `<br>${x.RcaCategory} : ${x.RcaRoot}`;
            }
          }
          relatedString !== '' ? origin += `${relatedString}<br><br>` : origin += '';
        });
      origin += `<br><b>ACTION</b><br><br><br>`;
      //Need to find field for Action
      origin += `<br><b>CORRECTION</b><br><br><br>`;
      item.CorrectionDetail !== '' ? origin += `${item.CorrectionDetail.replace(/"/g,"'")}<br><br>` : origin += '';
      item.CorrectionTargetDate ? origin += `<b>Correction Target:</b> ${item.CorrectionTargetDate}<br><br>` : '';
      item.CorrectionComplete ? origin += `<b>Correction Complete:</b> ${item.CorrectionComplete}<br><br>` : '';
      item.CorrectionDts ?  origin += `<b>Originating  DTS/DEV-ID Issue:</b> ${item.CorrectionDts}<br><br>` : '';
      item.CorrectionDtsComplete ? origin += `<b>DTS/DEV-ID Complete:</b> ${item.CorrectionDtsComplete}<br><br>` : '';
      item.CorrectionCategory ? origin += `<b>Bug Audit Category:</b> ${item.CorrectionCategory}<br><br>` : '';
      origin += `<b>NO ACTION</b><br><br>`;
      item.NoActionReason !== '' ? origin += `${item.NoActionReason.replace(/"/g,"'")}<br><br>` : origin += '';
      origin += `<b>RCA/ACTION APPROVAL</b><br><br>`;
      item.ApprovalFiledBy ? origin += `<b>Filed By:</b> ${item.ApprovalFiledBy} @ ${item.ApprovalFiledTime}<br><br>` : '';
      item.ApprovalNotes !== '' ? origin += `Notes: ${item.ApprovalNotes.replace(/"/g,"'")}<br><br>` : origin += '';
    
      synopsis = `<br><b>CAPA PLAN</b><br><br><br>`;
     item.CapaFiledBy ?  synopsis += `<b>Filed By:</b> ${item.CapaFiledBy} @ ${item.CapaFiledTime}<br><br>` : '';
      // Check if Cause Category needs to be repeated
      item.CapaScope !== '' ? synopsis += `<b>Scope:</b> ${item.CapaScope.replace(/"/g,"'")}<br><br>` : synopsis += '';
      item.CapaActivities !== '' ? synopsis += `<b>Activities:</b> ${item.CapaActivities.replace(/"/g,"'")}<br><br>` : synopsis += '';

      item.CapaSchedule !== '' ? synopsis += `<b>Schedulee:</b> ${item.CapaSchedule.replace(/"/g,"'")}<br><br>` : synopsis += '';
      item.CapaResources !== '' ? synopsis += `<b>Resources:</b> ${item.CapaResources.replace(/"/g,"'")}<br><br>` : synopsis += '';
     item.CapaImplementFrom ? synopsis += `<b>Implement From:</b> ${item.CapaImplementFrom}<br><br>` : '';
     item.CapaImplementThru ? synopsis += `<b>Implement Thru:</b> ${item.CapaImplementThru}<br><br>` : '';
      // item.CapaCorrectDetail !==''? synopsis += `<b>Correction Detail:</b> ${item.CapaCorrectDetail.replace(/"/g,"'")}<br><br>` : synopsis +='';
      // synopsis += `<b>Correction Target:</b> ${item.CapaCorrectTarget}<br><br>`;
      // synopsis += `<b>Correction Complete:</b> ${item.CapaCorrectComplete}<br><br>`;    

      synopsis += `<br><b>CAPA PLAN ADDENDUM</b><br><br><br>`;
      item.CapaAddendumNotes !== '' ? synopsis += `<b>Notes:</b> ${item.CapaAddendumNotes.replace(/"/g,"'")}<br><br>` : synopsis += '';
      synopsis += `<br><b>CAPA PLAN VERIFICATION</b><br><br><br>`;
      synopsis += `<b>Verification Person:</b> ${item.CapaVerifyPerson}<br><br>`;
      synopsis += `<b>Verification By:</b> ${item.CapaVerifyFiledBy}<br><br>`;
      await knex.select().from('LogIssueIso9001').where('IDissue', item.IDissue)
        .then((rows) => {
          let isoString = '';
          if (rows.length > 0) {
            isoString = `<b>ISO 9001:</b> <br>`;
            for (let iso of rows) {
              isoString += `${iso.Iso9001}<br>`;
            }
          }
          isoString !== '' ? synopsis += `${isoString}<br>` : synopsis += '';
        });
      await knex.select().from('LogIssueIso27001').where('IDissue', item.IDissue)
        .then((rows) => {
          let isoString = '';
          if (rows.length > 0) {
            isoString = `<b>ISO 27001:</b> <br>`;
            for (let iso of rows) {
              isoString += `${iso.Iso27001}<br>`;
            }
          }
          isoString !== '' ? synopsis += `${isoString}<br>` : synopsis += '';
        });

//too long in some rows, causing the csv to crash that item
      item.CapaVerifyNotes !== '' ? synopsis += `"<b>Notes:</b> ${item.CapaVerifyNotes.replace(/"/g,"'")}<br><br>"` : synopsis += '';
      synopsis += `<br><b>CAPA PLAN APPROVAL</b><br><br><br>`;
    item.CapaReviewFiledBy ?  synopsis += `<b>Filed By:</b> ${item.CapaReviewFiledBy} @ ${item.CapaReviewFiledTime}<br><br>` : '';
      item.CapaAction !== '' ? synopsis += `<b>Notes:</b> ${item.CapaAction.replace(/"/g,"'")}<br><br>` : synopsis += '';
      synopsis += `<br><b>CAPA APPROVAL</b><br><br><br>`;
      synopsis += `<b>Filed By:</b> ${item.CapaApprovalFiledBy} @ ${item.CapaApprovalFiledTime}<br><br>`;
      item.CapaApprovalNotes !== '' ? synopsis += `"<b>Notes:</b> ${item.CapaApprovalNotes.replace(/"/g,"'")}<br><br>"` : synopsis += '';
      currentSetup = `<br><b>INTERNAL AUDIT</b><br><br><br>`;
     item.AuditInfoFiledBy ? currentSetup += `<b>Filed By:</b> ${item.AuditInfoFiledBy} @ ${item.AuditInfoFiledTime}<br><br>` : '';
     item.AuditReadyDate ? currentSetup += `<b>Ready For Audit:</b> ${item.AuditReadyDate}<br><br>` : '';
      item.AuditConsiderations !== '' ? currentSetup += `<b>Audit Considerations:</b> ${item.AuditConsiderations.replace(/"/g,"'")}<br><br>` : currentSetup += '';
      item.AuditReport !== '' ? currentSetup += `<b>Audit Report:</b> ${item.AuditReport.replace(/"/g,"'")}<br><br>` : currentSetup += '';
      item.AuditNotes !== '' ? currentSetup += `<b>Notes:</b> ${item.AuditNotes.replace(/"/g,"'")}<br><br>` : currentSetup += '';

      await knex.select().from('LogIssueAssigned').where('IDissue', item.IDissue).limit(1)
                .then((rows) => {
                    for (let row of rows) {
                        let {
                            Assigned
                        } = row;
                        assigned = Assigned;
                    }
                });
        reviewer = item.GenInfoReviewer;
        facilitator = item.GenInfoFacilitator;
        reportedDate = item.GenInfoReportedDate;

      let test =  {id, title, status, category, type, description, analysis, conversion, origin, synopsis, currentSetup, assigned, reviewer, facilitator, reportedDate};
      objectArray.push(test);
    }
  })
  .then(() =>
  csvWriter  
  .writeRecords(objectArray)
  .then(()=> console.log('The CSV file was written successfully')));
